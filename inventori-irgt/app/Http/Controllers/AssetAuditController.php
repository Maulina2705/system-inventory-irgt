<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAudit;
use App\Models\AssetAuditItem;
use App\Models\Location;
use App\Models\Placement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssetAuditController extends Controller
{
    /**
     * Daftar Berita Acara & Riwayat Audit Bulanan Aset.
     */
    public function index(Request $request): View
    {
        $query = AssetAudit::with(['location', 'placement', 'inspector'])->withCount('items');

        if ($request->filled('q')) {
            $search = trim($request->get('q'));
            $query->where(function ($q) use ($search) {
                $q->where('audit_code', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('inspector_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('month')) {
            $query->where('audit_month', $request->get('month'));
        }

        if ($request->filled('year')) {
            $query->where('audit_year', $request->get('year'));
        }

        $audits = $query->orderBy('audit_year', 'desc')->orderBy('audit_month', 'desc')->paginate(15)->withQueryString();

        $totalAudits = AssetAudit::count();
        $completedAudits = AssetAudit::where('status', 'COMPLETED')->count();

        return view('audits.index', compact('audits', 'totalAudits', 'completedAudits'));
    }

    /**
     * Form pembuatan sesi audit baru akhir bulan.
     */
    public function create(Request $request): View
    {
        $locations = Location::orderBy('name')->get();
        $placements = Placement::orderBy('name')->get();

        $selectedLocationId = $request->query('location_id');
        $selectedPlacementId = $request->query('placement_id');

        $assets = collect();
        if ($selectedLocationId || $selectedPlacementId) {
            $assetQuery = Asset::with(['assetItem', 'placement', 'location']);
            if ($selectedLocationId) {
                $assetQuery->where('location_id', $selectedLocationId);
            }
            if ($selectedPlacementId) {
                $assetQuery->where('placement_id', $selectedPlacementId);
            }
            $assets = $assetQuery->orderBy('name')->get();
        }

        return view('audits.create', compact('locations', 'placements', 'assets', 'selectedLocationId', 'selectedPlacementId'));
    }

    /**
     * Menyimpan data hasil inspeksi & audit akhir bulan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'audit_month' => ['required', 'integer', 'min:1', 'max:12'],
            'audit_year' => ['required', 'integer', 'min:2020', 'max:2099'],
            'location_id' => ['nullable', 'exists:locations,id'],
            'placement_id' => ['nullable', 'exists:placements,id'],
            'audit_date' => ['required', 'date'],
            'summary_notes' => ['nullable', 'string'],
            'coordinator_name' => ['required', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.asset_id' => ['required', 'exists:assets,id'],
            'items.*.condition' => ['required', 'in:GOOD,FAIR,POOR,DAMAGED'],
            'items.*.status' => ['required', 'in:ACTIVE,MAINTENANCE,DAMAGED,LOST,RETIRED'],
            'items.*.notes' => ['nullable', 'string'],
        ], [
            'title.required' => 'Judul audit / pemeriksaan wajib diisi.',
            'coordinator_name.required' => 'Nama Koordinator Labor Komputer wajib diisi.',
            'items.required' => 'Minimal harus ada 1 aset yang diperiksa.',
        ]);

        $auditCode = 'AUD-' . $validated['audit_year'] . str_pad((string)$validated['audit_month'], 2, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(uniqid(), -4));

        $user = auth()->user();

        $audit = AssetAudit::create([
            'audit_code' => $auditCode,
            'title' => $validated['title'],
            'audit_month' => $validated['audit_month'],
            'audit_year' => $validated['audit_year'],
            'location_id' => $validated['location_id'] ?? null,
            'placement_id' => $validated['placement_id'] ?? null,
            'inspector_user_id' => $user->id,
            'inspector_name' => $user->name,
            'audit_date' => $validated['audit_date'],
            'status' => 'COMPLETED',
            'summary_notes' => $validated['summary_notes'] ?? null,
            'coordinator_name' => $validated['coordinator_name'],
            'approved_at' => now(),
        ]);

        foreach ($validated['items'] as $itemData) {
            AssetAuditItem::create([
                'asset_audit_id' => $audit->id,
                'asset_id' => $itemData['asset_id'],
                'condition' => $itemData['condition'],
                'status' => $itemData['status'],
                'notes' => $itemData['notes'] ?? null,
                'checked_at' => now(),
            ]);

            // Sinkronkan status dan kondisi terkini ke aset
            Asset::where('id', $itemData['asset_id'])->update([
                'condition' => $itemData['condition'],
                'status' => $itemData['status'],
                'last_updated_by_user_id' => $user->id,
            ]);
        }

        return redirect()->route('audits.show', $audit->id)->with('success', "Berita Acara Pemeriksaan Aset #{$auditCode} berhasil disimpan dan disahkan!");
    }

    /**
     * Export Riwayat Berita Acara Audit ke Format CSV (Excel Compatible).
     */
    public function exportCsv(Request $request)
    {
        $query = $this->buildFilterQuery($request);
        $audits = $query->orderBy('audit_year', 'desc')->orderBy('audit_month', 'desc')->get();

        $filename = 'Rekap_Audit_Aset_IRGT_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($audits) {
            $handle = fopen('php://output', 'w');
            
            // UTF-8 BOM untuk Excel
            fputs($handle, "\xEF\xBB\xBF");

            // Header kolom
            fputcsv($handle, [
                'No',
                'Nomor Berita Acara',
                'Judul Pemeriksaan',
                'Bulan',
                'Tahun',
                'Tanggal Pelaksanaan',
                'Lokasi / Ruangan',
                'Petugas Pemeriksa (IT)',
                'Koordinator Laboratorium',
                'Status Pengesahan',
                'Total Aset Diperiksa',
                'Aset Kondisi Baik',
                'Aset Perlu Maintenance/Rusak',
                'Tanggal Disahkan',
                'Catatan Ringkasan'
            ]);

            $no = 1;
            foreach ($audits as $audit) {
                $goodCount = $audit->items->where('condition', 'GOOD')->count();
                $issueCount = $audit->items->whereIn('condition', ['POOR', 'DAMAGED'])->count();

                fputcsv($handle, [
                    $no++,
                    $audit->audit_code,
                    $audit->title,
                    date('F', mktime(0, 0, 0, $audit->audit_month, 10)),
                    $audit->audit_year,
                    $audit->audit_date ? $audit->audit_date->format('d/m/Y') : '-',
                    $audit->location->name ?? ($audit->placement->name ?? 'Semua Ruangan'),
                    $audit->inspector_name ?? '-',
                    $audit->coordinator_name,
                    $audit->status === 'COMPLETED' ? 'Disahkan' : 'Draft',
                    $audit->items->count(),
                    $goodCount,
                    $issueCount,
                    $audit->approved_at ? $audit->approved_at->format('d/m/Y H:i') : '-',
                    $audit->summary_notes ?? '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak Rekapitulasi Tahunan / Bulanan Berita Acara Audit (Print Ready / PDF).
     */
    public function printRecap(Request $request): View
    {
        $query = $this->buildFilterQuery($request);
        $audits = $query->orderBy('audit_year', 'desc')->orderBy('audit_month', 'desc')->get();

        $totalAudits = $audits->count();
        $totalItemsInspected = $audits->sum(fn($a) => $a->items->count());
        $completedCount = $audits->where('status', 'COMPLETED')->count();

        $filterYear = $request->get('year');
        $filterMonth = $request->get('month');

        return view('audits.print-recap', compact(
            'audits',
            'totalAudits',
            'totalItemsInspected',
            'completedCount',
            'filterYear',
            'filterMonth'
        ));
    }

    /**
     * Helper query builder untuk filter data audit.
     */
    private function buildFilterQuery(Request $request)
    {
        $query = AssetAudit::with(['location', 'placement', 'inspector', 'items']);

        if ($request->filled('q')) {
            $search = trim($request->get('q'));
            $query->where(function ($q) use ($search) {
                $q->where('audit_code', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('inspector_name', 'like', "%{$search}%")
                  ->orWhere('coordinator_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('month')) {
            $query->where('audit_month', $request->get('month'));
        }

        if ($request->filled('year')) {
            $query->where('audit_year', $request->get('year'));
        }

        return $query;
    }

    /**
     * Tampilkan detail hasil audit aset.
     */
    public function show(AssetAudit $audit): View
    {
        $audit->load(['location', 'placement', 'inspector', 'items.asset.assetItem', 'items.asset.location']);

        return view('audits.show', compact('audit'));
    }

    /**
     * Cetak Berita Acara Audit Aset Resmi (Portrait A4).
     */
    public function print(AssetAudit $audit): View
    {
        $audit->load(['location', 'placement', 'inspector', 'items.asset.assetItem', 'items.asset.location']);

        return view('audits.print', compact('audit'));
    }

    /**
     * Hapus arsip audit.
     */
    public function destroy(AssetAudit $audit)
    {
        $auditCode = $audit->audit_code;
        $audit->delete();

        return redirect()->route('audits.index')->with('success', "Berita Acara Audit {$auditCode} berhasil dihapus.");
    }
}
