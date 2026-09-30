<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\MaintenanceReport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class PublicReportController extends Controller
{
    /**
     * Tampilkan form pengaduan / lapor kendala publik dari hasil scan QR aset.
     */
    public function create(Request $request, string $token): View
    {
        $asset = Asset::where('qr_token', $token)
            ->with(['placement', 'location', 'assetType', 'assetItem'])
            ->firstOrFail();

        $groupAssets = collect();
        if ($asset->group_code) {
            $groupAssets = Asset::where('group_code', $asset->group_code)
                ->with(['assetType', 'assetItem'])
                ->get();
        }

        $selectedAssetId = $request->query('asset_id', $asset->id);
        $targetAsset = $groupAssets->firstWhere('id', (int)$selectedAssetId) ?? $asset;

        $departments = MaintenanceReport::DEPARTMENTS;

        return view('public-reports.create', compact('asset', 'groupAssets', 'targetAsset', 'departments'));
    }

    /**
     * Simpan pengaduan publik tanpa login.
     */
    public function store(Request $request, string $token)
    {
        $primaryAsset = Asset::where('qr_token', $token)->firstOrFail();

        // Tentukan aset target (bisa aset utama atau salah satu item di dalam grupnya)
        $targetAsset = $primaryAsset;
        if ($request->filled('target_asset_id') && $primaryAsset->group_code) {
            $found = Asset::where('group_code', $primaryAsset->group_code)
                ->where('id', $request->input('target_asset_id'))
                ->first();
            if ($found) {
                $targetAsset = $found;
            }
        }
        $asset = $targetAsset;

        $validated = $request->validate([
            'reporter_name' => ['required', 'string', 'max:255'],
            'reporter_department' => ['required', 'string', 'in:' . implode(',', array_keys(MaintenanceReport::DEPARTMENTS))],
            'reporter_phone' => ['nullable', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['nullable', 'in:LOW,MEDIUM,HIGH,EMERGENCY'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
        ], [
            'reporter_name.required' => 'Nama lengkap pelapor wajib diisi.',
            'reporter_department.required' => 'Pilih departemen / unit kerja Anda.',
            'reporter_department.in' => 'Departemen yang dipilih tidak valid.',
            'title.required' => 'Judul atau ringkasan kendala wajib diisi.',
            'description.required' => 'Deskripsi kendala wajib diisi.',
            'photo.mimes' => 'File bukti kendala hanya boleh berupa format JPG atau PNG.',
            'photo.max' => 'Ukuran foto maksimal adalah 5 MB.',
        ]);

        // Generate Nomor Tiket Pengaduan Unik (Format: TCK-YYYYMMDD-XXXX)
        $todayStr = date('Ymd');
        $countToday = MaintenanceReport::whereDate('created_at', today())->count();
        $sequence = $countToday + 1;
        $ticketNumber = 'TCK-' . $todayStr . '-' . str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);

        while (MaintenanceReport::where('report_number', $ticketNumber)->exists()) {
            $sequence++;
            $ticketNumber = 'TCK-' . $todayStr . '-' . str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);
        }

        // Upload dan kompres foto jika dilampirkan
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $this->compressAndStoreImage($request->file('photo'), 'maintenance_photos');
        }

        $userId = auth()->id() ?? null;

        $report = MaintenanceReport::create([
            'report_number' => $ticketNumber,
            'asset_id' => $asset->id,
            'user_id' => $userId,
            'reporter_name' => $validated['reporter_name'],
            'reporter_department' => $validated['reporter_department'],
            'reporter_phone' => $validated['reporter_phone'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'] ?? 'MEDIUM',
            'photo_path' => $photoPath,
            'status' => MaintenanceReport::STATUS_PENDING,
        ]);

        // Ubah status aset menjadi MAINTENANCE jika saat ini ACTIVE
        $oldStatus = $asset->status;
        if ($asset->status === 'ACTIVE') {
            $asset->update([
                'status' => 'MAINTENANCE',
            ]);
        }

        // Catat ke log histori aset
        AssetHistory::create([
            'asset_id' => $asset->id,
            'user_id' => $userId,
            'action' => 'MAINTENANCE_REPORTED',
            'old_status' => $oldStatus,
            'new_status' => $asset->status,
            'notes' => "Pengaduan (#{$ticketNumber}) diajukan oleh {$validated['reporter_name']} ({$validated['reporter_department']}): \"{$validated['title']}\"",
        ]);

        // Kirim Notifikasi Telegram ke Tim IT
        \App\Services\TelegramNotificationService::sendMaintenanceTicket($report);

        return view('public-reports.success', compact('report', 'asset'));
    }

    /**
     * Halaman pelacakan progress pengaduan publik dengan nomor tiket.
     */
    public function track(Request $request): View
    {
        $ticketQuery = trim((string)$request->get('ticket', $request->get('q', '')));
        $report = null;
        $searched = false;

        if ($ticketQuery !== '') {
            $searched = true;
            $report = MaintenanceReport::where('report_number', $ticketQuery)
                ->orWhere('report_number', strtoupper($ticketQuery))
                ->with(['asset.placement', 'asset.location', 'asset.assetType', 'asset.assetItem', 'handler'])
                ->first();
        }

        return view('public-reports.track', compact('report', 'ticketQuery', 'searched'));
    }

    /**
     * Mengompresi dan menyimpan file gambar bukti kendala.
     */
    private function compressAndStoreImage(\Illuminate\Http\UploadedFile $file, string $folder = 'maintenance_photos'): ?string
    {
        $mime = $file->getMimeType();
        $filePath = $file->getRealPath();

        $filename = Str::random(40) . '.jpg';
        $storageDir = storage_path('app/public/' . $folder);

        if (!file_exists($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        $destinationPath = $storageDir . '/' . $filename;

        $sourceImage = null;
        if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
            $sourceImage = @imagecreatefromjpeg($filePath);
        } elseif ($mime === 'image/png') {
            $sourceImage = @imagecreatefrompng($filePath);
        }

        if (!$sourceImage) {
            return $file->store($folder, 'public');
        }

        $origWidth = imagesx($sourceImage);
        $origHeight = imagesy($sourceImage);

        $maxDimension = 1600;
        $targetWidth = $origWidth;
        $targetHeight = $origHeight;

        if ($origWidth > $maxDimension || $origHeight > $maxDimension) {
            if ($origWidth > $origHeight) {
                $targetWidth = $maxDimension;
                $targetHeight = (int) round(($origHeight / $origWidth) * $maxDimension);
            } else {
                $targetHeight = $maxDimension;
                $targetWidth = (int) round(($origWidth / $origHeight) * $maxDimension);
            }
        }

        $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);

        $white = imagecolorallocate($targetImage, 255, 255, 255);
        imagefilledrectangle($targetImage, 0, 0, $targetWidth, $targetHeight, $white);

        imagecopyresampled(
            $targetImage,
            $sourceImage,
            0, 0, 0, 0,
            $targetWidth,
            $targetHeight,
            $origWidth,
            $origHeight
        );

        imagejpeg($targetImage, $destinationPath, 75);

        imagedestroy($sourceImage);
        imagedestroy($targetImage);

        return $folder . '/' . $filename;
    }
}
