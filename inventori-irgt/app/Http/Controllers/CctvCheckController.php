<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\CctvCheck;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CctvCheckController extends Controller
{
    /**
     * Dashboard Pemantauan & Riwayat Pemeriksaan CCTV.
     */
    public function index(Request $request): View
    {
        // Ambil semua aset yang bertipe CCTV (kode CC atau nama CCTV)
        $cctvAssets = Asset::whereHas('assetItem', function ($q) {
            $q->where('code', 'CC');
        })->orWhere('name', 'like', '%CCTV%')
          ->with(['location', 'placement', 'cctvChecks'])
          ->get();

        $query = CctvCheck::with(['asset.location', 'asset.placement', 'inspector']);

        if ($request->filled('status')) {
            $query->where('network_status', $request->get('status'));
        }

        if ($request->filled('verdict')) {
            $query->where('overall_verdict', $request->get('verdict'));
        }

        $checks = $query->orderBy('check_date', 'desc')->orderBy('id', 'desc')->paginate(15)->withQueryString();

        $totalCctv = $cctvAssets->count();
        $onlineCount = $cctvAssets->filter(fn($a) => $a->cctvChecks->first()?->network_status === 'ONLINE')->count();
        $needMaintenanceCount = $cctvAssets->filter(fn($a) => in_array($a->cctvChecks->first()?->overall_verdict, ['NEED_MAINTENANCE', 'REPLACE_DEVICE']))->count();

        return view('cctv.index', compact('cctvAssets', 'checks', 'totalCctv', 'onlineCount', 'needMaintenanceCount'));
    }

    /**
     * Form Checklist Pemeriksaan CCTV (Jaringan, Fisik, Memori).
     */
    public function create(Request $request): View
    {
        $cctvAssets = Asset::whereHas('assetItem', function ($q) {
            $q->where('code', 'CC');
        })->orWhere('name', 'like', '%CCTV%')
          ->with(['location', 'placement'])
          ->orderBy('name')
          ->get();

        $selectedAssetId = $request->query('asset_id');
        $selectedAsset = $cctvAssets->firstWhere('id', (int)$selectedAssetId);

        return view('cctv.create', compact('cctvAssets', 'selectedAsset'));
    }

    /**
     * Simpan hasil pemeriksaan diagnostik CCTV.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => ['required', 'exists:assets,id'],
            'check_date' => ['required', 'date'],
            'network_status' => ['required', 'in:ONLINE,OFFLINE,UNSTABLE'],
            'ip_address' => ['nullable', 'string', 'max:50'],
            'ping_ms' => ['nullable', 'integer', 'min:0'],
            'stream_status' => ['required', 'in:OK,NO_VIDEO,LAG,FLICKER'],
            'physical_condition' => ['required', 'in:CLEAN,DIRTY_LENS,BLURRY,WATER_DAMAGE,LOOSE_BRACKET,DAMAGED'],
            'night_vision_status' => ['required', 'in:OK,FAIL,NOT_APPLICABLE'],
            'ptz_function' => ['required', 'in:NORMAL,STUCK,NOT_APPLICABLE'],
            'storage_type' => ['required', 'in:SD_CARD,NVR_HDD,CLOUD,NONE'],
            'storage_status' => ['required', 'in:RECORDING_NORMAL,OVERFLOW_ERROR,CORRUPT,NO_STORAGE,UNFORMATTED'],
            'storage_capacity_gb' => ['nullable', 'integer', 'min:0'],
            'days_retained' => ['nullable', 'integer', 'min:0'],
            'overall_verdict' => ['required', 'in:NORMAL,NEED_MAINTENANCE,REPLACE_DEVICE'],
            'notes' => ['nullable', 'string'],
        ], [
            'asset_id.required' => 'Pilih unit CCTV yang diperiksa.',
            'check_date.required' => 'Tanggal pemeriksaan wajib diisi.',
        ]);

        $user = auth()->user();

        $check = CctvCheck::create([
            'asset_id' => $validated['asset_id'],
            'checked_by_user_id' => $user->id,
            'inspector_name' => $user->name,
            'check_date' => $validated['check_date'],
            'network_status' => $validated['network_status'],
            'ip_address' => $validated['ip_address'] ?? null,
            'ping_ms' => $validated['ping_ms'] ?? null,
            'stream_status' => $validated['stream_status'],
            'physical_condition' => $validated['physical_condition'],
            'night_vision_status' => $validated['night_vision_status'],
            'ptz_function' => $validated['ptz_function'],
            'storage_type' => $validated['storage_type'],
            'storage_status' => $validated['storage_status'],
            'storage_capacity_gb' => $validated['storage_capacity_gb'] ?? null,
            'days_retained' => $validated['days_retained'] ?? null,
            'overall_verdict' => $validated['overall_verdict'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Jika IP diisi, sinkronkan ke data asset
        if (!empty($validated['ip_address'])) {
            Asset::where('id', $validated['asset_id'])->update([
                'ip_address' => $validated['ip_address'],
            ]);
        }

        // Jika ada status kerusakan / perawatan
        if ($validated['overall_verdict'] === 'NEED_MAINTENANCE') {
            Asset::where('id', $validated['asset_id'])->update(['status' => 'MAINTENANCE']);
        } elseif ($validated['overall_verdict'] === 'NORMAL') {
            Asset::where('id', $validated['asset_id'])->update(['status' => 'ACTIVE', 'condition' => 'GOOD']);
        }

        return redirect()->route('cctv.index')->with('success', "Pemeriksaan CCTV berhasil disimpan! Status diagnostik telah diperbarui.");
    }

    /**
     * Hapus riwayat pemeriksaan CCTV.
     */
    public function destroy(CctvCheck $cctv)
    {
        $cctv->delete();

        return redirect()->route('cctv.index')->with('success', "Riwayat pemeriksaan CCTV berhasil dihapus.");
    }
}
