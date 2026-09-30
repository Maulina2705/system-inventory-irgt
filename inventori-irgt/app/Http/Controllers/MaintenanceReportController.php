<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\MaintenanceReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MaintenanceReportController extends Controller
{
    /**
     * Menampilkan daftar laporan maintenance.
     * User biasa hanya melihat laporannya sendiri.
     * Admin/Super Admin melihat seluruh laporan antrean dengan filter.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $isStaff = in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN], true);

        $query = MaintenanceReport::with(['asset.placement', 'asset.location', 'user', 'handler']);

        // Jika user biasa, hanya tampilkan laporannya sendiri
        if (! $isStaff) {
            $query->where('user_id', $user->id);
        }

        // Filter pencarian
        if ($request->filled('q')) {
            $search = trim($request->get('q'));
            $query->where(function ($q) use ($search) {
                $q->where('report_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('reporter_name', 'like', "%{$search}%")
                  ->orWhereHas('asset', function ($qa) use ($search) {
                      $qa->where('name', 'like', "%{$search}%")
                         ->orWhere('asset_code', 'like', "%{$search}%");
                  });
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter prioritas
        if ($request->filled('priority')) {
            $query->where('priority', $request->get('priority'));
        }

        $perPageInput = $request->input('per_page', '15');
        if ($perPageInput === 'all' || $perPageInput === 'semua') {
            $perPage = 999999;
        } else {
            $perPage = (int) $perPageInput;
            if (!in_array($perPage, [15, 25, 50, 100, 150, 200], true)) {
                $perPage = 15;
            }
        }

        $reports = $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString();

        // Hitung statistik ringkasan
        if ($isStaff) {
            $totalAll = MaintenanceReport::count();
            $totalPending = MaintenanceReport::where('status', MaintenanceReport::STATUS_PENDING)->count();
            $totalInProgress = MaintenanceReport::where('status', MaintenanceReport::STATUS_IN_PROGRESS)->count();
            $totalResolved = MaintenanceReport::where('status', MaintenanceReport::STATUS_RESOLVED)->count();
        } else {
            $totalAll = MaintenanceReport::where('user_id', $user->id)->count();
            $totalPending = MaintenanceReport::where('user_id', $user->id)->where('status', MaintenanceReport::STATUS_PENDING)->count();
            $totalInProgress = MaintenanceReport::where('user_id', $user->id)->where('status', MaintenanceReport::STATUS_IN_PROGRESS)->count();
            $totalResolved = MaintenanceReport::where('user_id', $user->id)->where('status', MaintenanceReport::STATUS_RESOLVED)->count();
        }

        return view('reports.index', compact(
            'reports',
            'isStaff',
            'totalAll',
            'totalPending',
            'totalInProgress',
            'totalResolved'
        ));
    }

    /**
     * Form pembuatan laporan pengajuan maintenance baru.
     */
    public function create(Request $request): View
    {
        $selectedAsset = null;
        if ($request->filled('asset_id')) {
            $selectedAsset = Asset::with(['placement', 'location', 'assetType', 'assetItem'])
                ->find($request->get('asset_id'));
        }

        // Daftar aset untuk dipilih
        $assets = Asset::orderBy('name')
            ->select('id', 'asset_code', 'name', 'placement_id', 'location_id')
            ->with(['placement:id,name', 'location:id,name'])
            ->get();

        return view('reports.create', compact('selectedAsset', 'assets'));
    }

    /**
     * Menyimpan pengajuan laporan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => ['required', 'exists:assets,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'in:LOW,MEDIUM,HIGH,EMERGENCY'],
            'reporter_phone' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
        ], [
            'asset_id.required' => 'Pilih perangkat/aset yang mengalami kendala.',
            'title.required' => 'Judul atau ringkasan kendala wajib diisi.',
            'description.required' => 'Deskripsi detail gejala kerusakan wajib diisi.',
            'photo.mimes' => 'File bukti kendala hanya boleh berupa format JPG atau PNG.',
            'photo.max' => 'Ukuran foto maksimal adalah 5 MB.',
        ]);

        $user = auth()->user();

        // Generate Nomor Laporan Unik (Format: REP-YYYYMMDD-XXXX)
        $todayStr = date('Ymd');
        $countToday = MaintenanceReport::whereDate('created_at', today())->count();
        $sequence = $countToday + 1;
        $reportNumber = 'REP-' . $todayStr . '-' . str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);

        // Pastikan unik jika ada benturan
        while (MaintenanceReport::where('report_number', $reportNumber)->exists()) {
            $sequence++;
            $reportNumber = 'REP-' . $todayStr . '-' . str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);
        }

        // Upload dan kompres foto jika dilampirkan
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $this->compressAndStoreImage($request->file('photo'), 'maintenance_photos');
        }

        $report = MaintenanceReport::create([
            'report_number' => $reportNumber,
            'asset_id' => $validated['asset_id'],
            'user_id' => $user->id,
            'reporter_name' => $user->name,
            'reporter_phone' => $validated['reporter_phone'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'photo_path' => $photoPath,
            'status' => MaintenanceReport::STATUS_PENDING,
        ]);

        // Catat ke log histori aset terkait
        $asset = Asset::find($validated['asset_id']);
        if ($asset) {
            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => $user->id,
                'action' => 'MAINTENANCE_REPORTED',
                'old_status' => $asset->status,
                'new_status' => $asset->status,
                'notes' => "Laporan kendala (#{$reportNumber}) diajukan oleh {$user->name}: \"{$validated['title']}\"",
            ]);
        }

        // Kirim Notifikasi Telegram ke Tim IT
        \App\Services\TelegramNotificationService::sendMaintenanceTicket($report);

        return redirect()
            ->route('reports.show', $report->id)
            ->with('success', "Laporan maintenance berhasil diajukan dengan nomor tiket #{$reportNumber}! Tim IT akan segera menindaklanjuti.");
    }

    /**
     * Menampilkan detail laporan dan visual progress tracker.
     */
    public function show(MaintenanceReport $report): View
    {
        $user = auth()->user();
        $isStaff = in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN], true);

        // Hak akses: User biasa hanya boleh melihat laporannya sendiri
        if (! $isStaff && $report->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat laporan ini.');
        }

        $report->load([
            'asset.placement',
            'asset.location',
            'asset.assetType',
            'asset.assetItem',
            'user',
            'handler',
        ]);

        return view('reports.show', compact('report', 'isStaff'));
    }

    /**
     * Memperbarui status pengerjaan tiket laporan oleh Petugas IT dan pencatatan biaya maintenance.
     * Mendukung alur: IN_PROGRESS (Sedang Dikerjakan), RESOLVED (Selesai), REJECTED (Ditolak).
     */
    public function updateStatus(Request $request, MaintenanceReport $report)
    {
        $user = auth()->user();

        // Validasi input
        $validated = $request->validate([
            'status' => ['required', 'in:IN_PROGRESS,RESOLVED,REJECTED'],
            'technician_notes' => ['nullable', 'string', 'max:1000'],
            'labour_cost' => ['nullable', 'numeric', 'min:0'],
            'spare_part_cost' => ['nullable', 'numeric', 'min:0'],
            'other_cost' => ['nullable', 'numeric', 'min:0'],
            'vendor_name' => ['nullable', 'string', 'max:255'],
            'invoice_number' => ['nullable', 'string', 'max:100'],
            'cost_notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'status.required' => 'Status pengerjaan wajib dipilih.',
        ]);

        $newStatus = $validated['status'];
        $notes = trim($validated['technician_notes'] ?? '');
        $asset = $report->asset;

        $costData = [
            'labour_cost' => $request->filled('labour_cost') ? (float)$request->labour_cost : $report->labour_cost,
            'spare_part_cost' => $request->filled('spare_part_cost') ? (float)$request->spare_part_cost : $report->spare_part_cost,
            'other_cost' => $request->filled('other_cost') ? (float)$request->other_cost : $report->other_cost,
            'vendor_name' => $request->filled('vendor_name') ? $request->vendor_name : $report->vendor_name,
            'invoice_number' => $request->filled('invoice_number') ? $request->invoice_number : $report->invoice_number,
            'cost_notes' => $request->filled('cost_notes') ? $request->cost_notes : $report->cost_notes,
        ];

        if ($newStatus === MaintenanceReport::STATUS_IN_PROGRESS) {
            // Status: Sedang Dikerjakan
            $report->update(array_merge([
                'status' => MaintenanceReport::STATUS_IN_PROGRESS,
                'handled_by_user_id' => $user->id,
                'technician_notes' => $notes ?: 'Tiket diterima dan sedang dalam penanganan teknisi IT.',
            ], $costData));

            // Update status aset menjadi MAINTENANCE
            if ($asset && $asset->status !== 'MAINTENANCE') {
                $oldStatus = $asset->status;
                $asset->update([
                    'status' => 'MAINTENANCE',
                    'last_updated_by_user_id' => $user->id,
                ]);

                // Catat log histori aset
                AssetHistory::create([
                    'asset_id' => $asset->id,
                    'user_id' => $user->id,
                    'action' => 'MAINTENANCE_REPORTED',
                    'old_status' => $oldStatus,
                    'new_status' => 'MAINTENANCE',
                    'notes' => "Laporan #{$report->report_number} diproses oleh {$user->name}. Status aset diubah menjadi MAINTENANCE." . ($notes ? " Catatan: {$notes}" : ""),
                ]);
            }

            return back()->with('success', "Tiket #{$report->report_number} berhasil diperbarui: SEDANG DIKERJAKAN oleh {$user->name}!");
        }

        if ($newStatus === MaintenanceReport::STATUS_RESOLVED) {
            // Status: Selesai Diperbaiki
            if (empty($notes)) {
                return back()->with('error', 'Wajib mengisi catatan perbaikan/solusi sebelum menyelesaikan laporan!');
            }

            $report->update(array_merge([
                'status' => MaintenanceReport::STATUS_RESOLVED,
                'handled_by_user_id' => $user->id,
                'technician_notes' => $notes,
                'resolved_at' => now(),
            ], $costData));

            // Update status aset kembali menjadi ACTIVE + simpan Solver
            if ($asset) {
                $oldStatus = $asset->status;
                $asset->update([
                    'status' => 'ACTIVE',
                    'condition' => 'GOOD',
                    'last_solved_by_user_id' => $user->id,
                    'last_solved_at' => now(),
                    'last_updated_by_user_id' => $user->id,
                ]);

                // Catat log histori penyelesaian perbaikan (REPAIR_SOLVED)
                AssetHistory::create([
                    'asset_id' => $asset->id,
                    'user_id' => $user->id,
                    'action' => 'REPAIR_SOLVED',
                    'old_status' => $oldStatus,
                    'new_status' => 'ACTIVE',
                    'notes' => "Laporan #{$report->report_number} diselesaikan oleh {$user->name} (Status aset kembali Aktif & Normal). Solusi: {$notes}",
                ]);
            }

            return back()->with('success', "Tiket #{$report->report_number} SELESAI DIPERBAIKI! Solver dan riwayat aset telah diperbarui secara otomatis.");
        }

        if ($newStatus === MaintenanceReport::STATUS_REJECTED) {
            // Status: Ditolak / Dibatalkan
            if (empty($notes)) {
                return back()->with('error', 'Wajib mengisi alasan penolakan/pembatalan laporan!');
            }

            $report->update([
                'status' => MaintenanceReport::STATUS_REJECTED,
                'handled_by_user_id' => $user->id,
                'technician_notes' => $notes,
            ]);

            // Kembalikan status aset ke ACTIVE jika tidak ada tiket lain yang aktif
            if ($asset && $asset->status === 'MAINTENANCE') {
                $otherActiveReports = MaintenanceReport::where('asset_id', $asset->id)
                    ->where('id', '!=', $report->id)
                    ->whereIn('status', [MaintenanceReport::STATUS_PENDING, MaintenanceReport::STATUS_IN_PROGRESS])
                    ->exists();

                if (!$otherActiveReports) {
                    $asset->update([
                        'status' => 'ACTIVE',
                        'last_updated_by_user_id' => $user->id,
                    ]);
                }
            }

            // Catat log histori aset
            if ($asset) {
                AssetHistory::create([
                    'asset_id' => $asset->id,
                    'user_id' => $user->id,
                    'action' => 'UPDATED',
                    'notes' => "Laporan #{$report->report_number} ditolak oleh {$user->name}. Alasan: {$notes}",
                ]);
            }

            return back()->with('success', "Tiket #{$report->report_number} telah ditolak/dibatalkan.");
        }

        return back();
    }

    /**
     * Export rekap laporan maintenance ke format CSV (Excel).
     */
    public function exportCsv(Request $request)
    {
        $query = $this->buildFilterQuery($request);
        $reports = $query->orderBy('id', 'desc')->get();

        $filename = 'Rekap_Maintenance_IRGT_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($reports) {
            $handle = fopen('php://output', 'w');
            
            // Tulis UTF-8 BOM
            fputs($handle, "\xEF\xBB\xBF");

            // Header Kolom
            fputcsv($handle, [
                'No',
                'Nomor Tiket',
                'Tanggal Lapor',
                'Kode Aset',
                'Nama Perangkat',
                'Lokasi / Ruangan',
                'Pelapor',
                'Departemen / Unit',
                'No. Kontak',
                'Judul Kendala',
                'Deskripsi Kendala',
                'Tingkat Urgensi',
                'Status Pengerjaan',
                'Teknisi Penangan',
                'Catatan / Solusi Teknisi',
                'Waktu Selesai'
            ]);

            $no = 1;
            foreach ($reports as $r) {
                fputcsv($handle, [
                    $no++,
                    $r->report_number,
                    $r->created_at ? $r->created_at->format('d/m/Y H:i') : '-',
                    $r->asset->asset_code ?? '-',
                    $r->asset->name ?? '-',
                    $r->asset->location->name ?? '-',
                    $r->reporter_name,
                    $r->reporter_department ?? ($r->user->role ?? '-'),
                    $r->reporter_phone ?? '-',
                    $r->title,
                    $r->description,
                    $r->priority,
                    $r->status,
                    $r->handler->name ?? '-',
                    $r->technician_notes ?? '-',
                    $r->resolved_at ? date('d/m/Y H:i', strtotime($r->resolved_at)) : '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak Rekapitulasi Formal Laporan Maintenance (Print / Save to PDF).
     */
    public function printRecap(Request $request): \Illuminate\View\View
    {
        $query = $this->buildFilterQuery($request);
        $reports = $query->orderBy('id', 'desc')->get();

        $totalCount = $reports->count();
        $pendingCount = $reports->where('status', MaintenanceReport::STATUS_PENDING)->count();
        $inProgressCount = $reports->where('status', MaintenanceReport::STATUS_IN_PROGRESS)->count();
        $resolvedCount = $reports->where('status', MaintenanceReport::STATUS_RESOLVED)->count();
        $rejectedCount = $reports->where('status', MaintenanceReport::STATUS_REJECTED)->count();

        return view('reports.print-recap', compact(
            'reports',
            'totalCount',
            'pendingCount',
            'inProgressCount',
            'resolvedCount',
            'rejectedCount'
        ));
    }

    /**
     * Helper query builder untuk filter laporan maintenance.
     */
    private function buildFilterQuery(Request $request)
    {
        $user = auth()->user();
        $isStaff = in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN], true);

        $query = MaintenanceReport::with(['asset.placement', 'asset.location', 'user', 'handler']);

        if (! $isStaff) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('q')) {
            $search = trim($request->get('q'));
            $query->where(function ($q) use ($search) {
                $q->where('report_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('reporter_name', 'like', "%{$search}%")
                  ->orWhereHas('asset', function ($qa) use ($search) {
                      $qa->where('name', 'like', "%{$search}%")
                         ->orWhere('asset_code', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->get('priority'));
        }

        return $query;
    }

    /**
     * Menghapus data laporan (Khusus Admin / Super Admin).
     */
    public function destroy(MaintenanceReport $report)
    {
        $reportNumber = $report->report_number;

        // Hapus foto jika ada
        if ($report->photo_path && Storage::disk('public')->exists($report->photo_path)) {
            Storage::disk('public')->delete($report->photo_path);
        }

        $report->delete();

        return redirect()
            ->route('reports.index')
            ->with('success', "Laporan {$reportNumber} berhasil dihapus!");
    }

    /**
     * Mengompresi dan menyimpan file gambar bukti kendala (hanya PNG / JPG / JPEG).
     */
    private function compressAndStoreImage(\Illuminate\Http\UploadedFile $file, string $folder = 'maintenance_photos'): ?string
    {
        $mime = $file->getMimeType();
        $filePath = $file->getRealPath();

        $filename = \Illuminate\Support\Str::random(40) . '.jpg';
        $storageDir = storage_path('app/public/' . $folder);

        if (!file_exists($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        $destinationPath = $storageDir . '/' . $filename;

        // Buat image resource dengan GD
        $sourceImage = null;
        if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
            $sourceImage = @imagecreatefromjpeg($filePath);
        } elseif ($mime === 'image/png') {
            $sourceImage = @imagecreatefrompng($filePath);
        }

        // Fallback jika GD gagal membuat resource
        if (!$sourceImage) {
            return $file->store($folder, 'public');
        }

        $origWidth = imagesx($sourceImage);
        $origHeight = imagesy($sourceImage);

        // Batasi resolusi maksimal 1600px untuk efisiensi
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

        // Background putih untuk konversi PNG transparan ke JPEG
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

        // Simpan sebagai JPEG berkualitas 75% (sangat hemat ukuran file)
        imagejpeg($targetImage, $destinationPath, 75);

        imagedestroy($sourceImage);
        imagedestroy($targetImage);

        return $folder . '/' . $filename;
    }
}
