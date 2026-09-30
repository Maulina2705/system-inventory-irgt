<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\Placement;
use App\Models\Location;
use App\Models\AssetType;
use App\Models\AssetItem;
use App\Services\AssetService;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssetController extends Controller
{
    /**
     * Menampilkan daftar seluruh inventaris dengan pencarian dan filter.
     */
    public function index(Request $request)
    {
        $query = Asset::with([
            'placement',
            'location',
            'assetType',
            'assetItem',
            'creator',
            'solver',
        ]);

        if ($request->filled('q')) {
            $search = trim($request->get('q'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('asset_code', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('assigned_to', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->get('condition'));
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->get('location_id'));
        }

        if ($request->filled('placement_id')) {
            $query->where('placement_id', $request->get('placement_id'));
        }

        if ($request->filled('group_code')) {
            $query->where('group_code', $request->get('group_code'));
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

        $assets = $query->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        $placements = Placement::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $groups = Asset::whereNotNull('group_code')
            ->where('group_code', '!=', '')
            ->select('group_code', 'group_name')
            ->distinct()
            ->orderBy('group_code')
            ->get();

        return view('assets.index', compact('assets', 'placements', 'locations', 'groups'));
    }

    /**
     * Menampilkan form tambah inventaris.
     */
    public function create()
    {
        $placements = Placement::orderBy('code')->get();
        $locations = Location::orderBy('code')->get();
        $assetTypes = AssetType::orderBy('code')->get();
        $assetItems = AssetItem::orderBy('code')->get();

        return view('assets.create', compact(
            'placements',
            'locations',
            'assetTypes',
            'assetItems'
        ));
    }

    /**
     * Menyimpan inventaris baru.
     */
    public function store(Request $request)
    {
        $sn = trim((string)$request->input('serial_number'));
        if ($sn === '' || in_array(strtoupper($sn), ['-', 'TIDAK ADA', 'TIDAK ADA SN', 'N/A', 'NONE', 'NULL'])) {
            $request->merge(['serial_number' => null]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],

            'placement_id' => ['required', 'exists:placements,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'asset_type_id' => ['required', 'exists:asset_types,id'],
            'asset_item_id' => ['required', 'exists:asset_items,id'],

            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'specifications' => ['nullable', 'array'],
            'serial_number' => ['nullable', 'string', 'max:255', 'unique:assets,serial_number'],

            'group_code' => ['nullable', 'string', 'max:50'],
            'group_name' => ['nullable', 'string', 'max:100'],
            'is_group_primary' => ['nullable', 'boolean'],

            'ownership' => ['nullable', 'string', 'max:255'],
            'assigned_to' => ['nullable', 'string', 'max:255'],

            'status' => [
                'nullable',
                'in:ACTIVE,MAINTENANCE,DAMAGED,LOST,RETIRED,BORROWED'
            ],

            'condition' => [
                'nullable',
                'in:GOOD,FAIR,POOR,DAMAGED'
            ],

            'purchase_date' => ['nullable', 'date'],
            'vendor' => ['nullable', 'string', 'max:255'],
            'warranty_expiry' => ['nullable', 'date'],

            'ip_address' => ['nullable', 'ip'],
            'mac_address' => ['nullable', 'string', 'max:255'],

            'notes' => ['nullable', 'string'],
        ], [
            'serial_number.unique' => 'Nomor seri (Serial Number) ini sudah terdaftar pada aset lain!',
            'name.required' => 'Nama perangkat wajib diisi.',
            'year.required' => 'Tahun perolehan wajib diisi.',
        ]);

        $placement = Placement::findOrFail($validated['placement_id']);
        $location = Location::findOrFail($validated['location_id']);
        $assetType = AssetType::findOrFail($validated['asset_type_id']);
        $assetItem = AssetItem::findOrFail($validated['asset_item_id']);

        $service = new AssetService();

        $asset = $service->create(
            $placement,
            $location,
            $assetType,
            $assetItem,
            $validated['name'],
            $validated['year'],
            $validated
        );

        return redirect()
            ->route('assets.create')
            ->with(
                'success',
                'Inventaris berhasil ditambahkan dengan kode ' . $asset->asset_code
            );
    }

    /**
     * Generate QR Code SVG untuk aset.
     */
    public function qr(Asset $asset): Response
    {
        $url = route('asset.scan', $asset->qr_token);

        $renderer = new ImageRenderer(
            new RendererStyle(
                320,
                2,
                null,
                null,
                Fill::uniformColor(
                    new Rgb(255, 255, 255),
                    new Rgb(3, 105, 161) // #0369a1 sky blue
                )
            ),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $svg = $writer->writeString($url);

        return response($svg, 200)
            ->header('Content-Type', 'image/svg+xml');
    }

    /**
     * Halaman cetak label QR untuk aset.
     */
    public function printLabel(Asset $asset): \Illuminate\View\View
    {
        $asset->load(['placement', 'location', 'assetType', 'assetItem']);
        $groupMembers = collect();
        if ($asset->group_code) {
            $groupMembers = Asset::where('group_code', $asset->group_code)->with('assetItem')->get();
        }

        return view('assets.print-label', compact('asset', 'groupMembers'));
    }

    /**
     * Menampilkan form edit data inventaris.
     */
    public function edit(Asset $asset): \Illuminate\View\View
    {
        $asset->load(['placement', 'location', 'assetType', 'assetItem']);
        $placements = Placement::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $assetTypes = AssetType::orderBy('name')->get();
        $assetItems = AssetItem::orderBy('name')->get();

        return view('assets.edit', compact(
            'asset',
            'placements',
            'locations',
            'assetTypes',
            'assetItems'
        ));
    }

    /**
     * Memperbarui data inventaris yang ada.
     */
    public function update(Request $request, Asset $asset)
    {
        $sn = trim((string)$request->input('serial_number'));
        if ($sn === '' || in_array(strtoupper($sn), ['-', 'TIDAK ADA', 'TIDAK ADA SN', 'N/A', 'NONE', 'NULL'])) {
            $request->merge(['serial_number' => null]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'specifications' => ['nullable', 'array'],
            'serial_number' => ['nullable', 'string', 'max:255', 'unique:assets,serial_number,' . $asset->id],

            'group_code' => ['nullable', 'string', 'max:50'],
            'group_name' => ['nullable', 'string', 'max:100'],
            'is_group_primary' => ['nullable', 'boolean'],

            'placement_id' => ['required', 'exists:placements,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'asset_type_id' => ['required', 'exists:asset_types,id'],
            'asset_item_id' => ['required', 'exists:asset_items,id'],

            'ownership' => ['nullable', 'string', 'max:255'],
            'assigned_to' => ['nullable', 'string', 'max:255'],

            'status' => [
                'required',
                'in:ACTIVE,MAINTENANCE,DAMAGED,LOST,RETIRED,BORROWED'
            ],

            'condition' => [
                'required',
                'in:GOOD,FAIR,POOR,DAMAGED'
            ],

            'purchase_date' => ['nullable', 'date'],
            'vendor' => ['nullable', 'string', 'max:255'],
            'warranty_expiry' => ['nullable', 'date'],

            'ip_address' => ['nullable', 'ip'],
            'mac_address' => ['nullable', 'string', 'max:255'],

            'notes' => ['nullable', 'string'],
            'maintenance_notes' => ['nullable', 'string', 'max:500'],
        ], [
            'serial_number.unique' => 'Nomor seri (Serial Number) ini sudah terdaftar pada aset lain!',
            'name.required' => 'Nama perangkat wajib diisi.',
            'status.required' => 'Status operasional wajib dipilih.',
            'condition.required' => 'Kondisi fisik wajib dipilih.',
        ]);

        $oldStatus = $asset->status;
        $newStatus = $validated['status'];
        $userId = auth()->id() ?? null;
        $userName = auth()->user()->name ?? 'Petugas';
        $maintenanceNotes = $validated['maintenance_notes'] ?? null;
        unset($validated['maintenance_notes']);

        $validated['last_updated_by_user_id'] = $userId;

        // Cek jika ada penyelesaian perbaikan / kerusakan
        $action = 'UPDATED';
        $logNotes = "Data aset diperbarui oleh {$userName}";

        if (in_array($oldStatus, ['MAINTENANCE', 'DAMAGED']) && $newStatus === 'ACTIVE') {
            // Kerusakan berhasil diperbaiki (Solved)
            $validated['last_solved_by_user_id'] = $userId;
            $validated['last_solved_at'] = now();
            $action = 'REPAIR_SOLVED';
            $logNotes = "Perbaikan/Maintenance diselesaikan oleh {$userName} (Status kembali Aktif)." . ($maintenanceNotes ? " Catatan: {$maintenanceNotes}" : "");
        } elseif ($oldStatus === 'ACTIVE' && in_array($newStatus, ['MAINTENANCE', 'DAMAGED'])) {
            // Laporan kerusakan / maintenance baru
            $action = 'MAINTENANCE_REPORTED';
            $logNotes = "Status diubah menjadi {$newStatus} oleh {$userName}." . ($maintenanceNotes ? " Keterangan: {$maintenanceNotes}" : "");
        } elseif ($oldStatus !== $newStatus) {
            // Perubahan status umum
            $action = 'STATUS_CHANGED';
            $logNotes = "Status diubah dari {$oldStatus} menjadi {$newStatus} oleh {$userName}." . ($maintenanceNotes ? " Keterangan: {$maintenanceNotes}" : "");
        } elseif ($maintenanceNotes) {
            $logNotes .= ". Catatan: {$maintenanceNotes}";
        }

        $asset->update($validated);

        // Catat ke log histori
        AssetHistory::create([
            'asset_id' => $asset->id,
            'user_id' => $userId,
            'action' => $action,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'notes' => $logNotes,
        ]);

        return redirect()
            ->route('assets.index')
            ->with(
                'success',
                'Data inventaris ' . $asset->asset_code . ' berhasil diperbarui!'
            );
    }

    /**
     * Menampilkan riwayat kronologis (timeline log) aset.
     */
    public function history(Asset $asset): \Illuminate\View\View
    {
        $asset->load([
            'placement',
            'location',
            'assetType',
            'assetItem',
            'creator',
            'solver',
            'updater',
            'histories.user',
            'maintenanceReports.user',
            'maintenanceReports.handler',
        ]);

        return view('assets.history', compact('asset'));
    }

    /**
     * Menghapus data inventaris.
     */
    public function destroy(Asset $asset)
    {
        $code = $asset->asset_code;
        $asset->delete();

        return redirect()
            ->route('assets.index')
            ->with(
                'success',
                'Inventaris ' . $code . ' berhasil dihapus!'
            );
    }

    /**
     * Export data inventaris ke format CSV (kompatibel penuh Excel).
     */
    public function exportCsv(Request $request)
    {
        $query = $this->buildFilterQuery($request);
        $assets = $query->orderBy('id', 'desc')->get();

        $filename = 'Inventori_IRGT_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($assets) {
            $handle = fopen('php://output', 'w');
            
            // Tulis UTF-8 BOM untuk Microsoft Excel
            fputs($handle, "\xEF\xBB\xBF");

            // Header kolom
            fputcsv($handle, [
                'No',
                'Kode Inventaris',
                'Nama Perangkat',
                'Brand / Merk',
                'Model / Seri',
                'Serial Number',
                'Penempatan',
                'Lokasi / Ruangan',
                'Kategori / Tipe',
                'Jenis Item',
                'Tahun Perolehan',
                'Status Operasional',
                'Kondisi Fisik',
                'Kepemilikan',
                'Pengguna / PIC',
                'Tanggal Pembelian',
                'Vendor / Supplier',
                'Masa Garansi',
                'IP Address',
                'MAC Address',
                'Catatan / Keterangan',
                'Tanggal Ditambahkan'
            ]);

            $no = 1;
            foreach ($assets as $asset) {
                fputcsv($handle, [
                    $no++,
                    $asset->asset_code,
                    $asset->name,
                    $asset->brand ?? '-',
                    $asset->model ?? '-',
                    $asset->serial_number ?? '-',
                    $asset->placement->name ?? '-',
                    $asset->location->name ?? '-',
                    $asset->assetType->name ?? '-',
                    $asset->assetItem->name ?? '-',
                    $asset->inventory_year,
                    $asset->status,
                    $asset->condition,
                    $asset->ownership ?? '-',
                    $asset->assigned_to ?? '-',
                    $asset->purchase_date ? date('d/m/Y', strtotime($asset->purchase_date)) : '-',
                    $asset->vendor ?? '-',
                    $asset->warranty_expiry ? date('d/m/Y', strtotime($asset->warranty_expiry)) : '-',
                    $asset->ip_address ?? '-',
                    $asset->mac_address ?? '-',
                    $asset->notes ?? '-',
                    $asset->created_at ? $asset->created_at->format('d/m/Y H:i') : '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak Rekap Formal Daftar Inventaris (Print Ready / Save to PDF).
     */
    public function printRecap(Request $request): \Illuminate\View\View
    {
        $query = $this->buildFilterQuery($request);
        $assets = $query->orderBy('id', 'desc')->get();

        $totalCount = $assets->count();
        $activeCount = $assets->where('status', 'ACTIVE')->count();
        $maintenanceCount = $assets->where('status', 'MAINTENANCE')->count();
        $damagedCount = $assets->whereIn('status', ['DAMAGED', 'LOST', 'RETIRED'])->count();

        return view('assets.print-recap', compact(
            'assets',
            'totalCount',
            'activeCount',
            'maintenanceCount',
            'damagedCount'
        ));
    }

    /**
     * Cetak Massal Label QR Code dalam layout lembar stiker A4.
     */
    public function bulkPrintLabels(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = array_filter(explode(',', $ids));
        }

        if (empty($ids)) {
            // Jika tidak ada ID yang dipilih, ambil berdasarkan filter aktif atau semua aset
            $query = $this->buildFilterQuery($request);
            $assets = $query->orderBy('id', 'desc')->limit(100)->get();
        } else {
            $assets = Asset::with(['placement', 'location', 'assetType', 'assetItem'])
                ->whereIn('id', $ids)
                ->orderBy('id', 'desc')
                ->get();
        }

        if ($assets->isEmpty()) {
            return redirect()->route('assets.index')->with('error', 'Tidak ada inventaris yang dipilih untuk dicetak label!');
        }

        // Generate QR Code SVG untuk masing-masing aset
        foreach ($assets as $asset) {
            $url = route('asset.scan', $asset->qr_token);
            $asset->qr_svg = $this->generateQrSvgString($url);
        }

        return view('assets.bulk-print', compact('assets'));
    }

    /**
     * Cetak Kartu / Stiker Khusus Meja Workstation (Grup).
     */
     public function printGroupLabel(string $groupCode): \Illuminate\View\View
     {
         $assets = Asset::with(['placement', 'location', 'assetType', 'assetItem'])
             ->where('group_code', $groupCode)
             ->orderBy('is_group_primary', 'desc')
             ->orderBy('id', 'asc')
             ->get();

         if ($assets->isEmpty()) {
             return redirect()->route('assets.index')->with('error', "Grup meja {$groupCode} tidak ditemukan.");
         }

         $primaryAsset = $assets->firstWhere('is_group_primary', true) ?? $assets->first();
         $groupName = $primaryAsset->group_name ?? "Meja {$groupCode}";

         $url = route('asset.scan', $primaryAsset->qr_token);
         $qrSvg = $this->generateQrSvgString($url);

         return view('assets.group-print', compact('assets', 'primaryAsset', 'groupCode', 'groupName', 'qrSvg'));
     }

    /**
     * Helper query builder untuk filter aset.
     */
    private function buildFilterQuery(Request $request)
    {
        $query = Asset::with([
            'placement',
            'location',
            'assetType',
            'assetItem',
            'creator',
            'solver',
        ]);

        if ($request->filled('q')) {
            $search = trim($request->get('q'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('asset_code', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('assigned_to', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->get('condition'));
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->get('location_id'));
        }

        if ($request->filled('placement_id')) {
            $query->where('placement_id', $request->get('placement_id'));
        }

        if ($request->filled('group_code')) {
            $query->where('group_code', $request->get('group_code'));
        }

        return $query;
    }

    /**
     * Helper membuat string SVG QR Code.
     */
    private function generateQrSvgString(string $url): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(
                220,
                1,
                null,
                null,
                Fill::uniformColor(
                    new Rgb(255, 255, 255),
                    new Rgb(3, 105, 161)
                )
            ),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        return $writer->writeString($url);
    }
}