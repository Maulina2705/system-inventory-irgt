<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Location;
use App\Models\Placement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssetGroupController extends Controller
{
    /**
     * Halaman Manajemen Pengelompokan Aset (Meja Walas, Proyektor Kelas, Workstation Lab).
     */
    public function index(Request $request): View
    {
        $groupQuery = Asset::whereNotNull('group_code')
            ->where('group_code', '!=', '')
            ->with(['placement', 'location', 'assetType', 'assetItem']);

        if ($request->filled('q')) {
            $search = trim($request->get('q'));
            $groupQuery->where(function ($q) use ($search) {
                $q->where('group_code', 'like', "%{$search}%")
                  ->orWhere('group_name', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('asset_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('location_id')) {
            $groupQuery->where('location_id', $request->get('location_id'));
        }

        $allGroupedAssets = $groupQuery->orderBy('group_code')->orderBy('is_group_primary', 'desc')->get();

        // Kelompokkan aset berdasarkan group_code
        $groups = $allGroupedAssets->groupBy('group_code')->map(function ($items, $code) {
            $primary = $items->firstWhere('is_group_primary', true) ?? $items->first();
            $location = $primary->location->name ?? ($primary->placement->name ?? 'Laboratorium / Kelas');
            $groupName = $primary->group_name ?? "Grup {$code}";

            // Deteksi tipe grup (Walas Meja, Walas Proyektor, Lab Workstation, dll.)
            $typeLabel = 'Workstation';
            $badgeColor = '#0369a1';

            if (str_contains(strtoupper($code), 'PROY') || str_contains(strtoupper($groupName), 'PROYEKTOR') || $items->contains(fn($i) => str_contains(strtoupper($i->name), 'PROYEKTOR') || ($i->assetItem->code ?? '') === 'PR')) {
                $typeLabel = 'Proyektor Kelas / Walas';
                $badgeColor = '#7c3aed';
            } elseif (str_contains(strtoupper($code), 'WALAS') || str_contains(strtoupper($groupName), 'WALAS') || str_contains(strtoupper($groupName), 'GURU')) {
                $typeLabel = 'Meja Guru / Walas';
                $badgeColor = '#0284c7';
            } elseif (str_contains(strtoupper($code), 'LAB') || str_contains(strtoupper($code), 'WS')) {
                $typeLabel = 'Workstation Lab';
                $badgeColor = '#059669';
            }

            return (object) [
                'code' => $code,
                'name' => $groupName,
                'type_label' => $typeLabel,
                'badge_color' => $badgeColor,
                'location' => $location,
                'location_id' => $primary->location_id,
                'primary_asset' => $primary,
                'items' => $items,
                'total_items' => $items->count(),
                'active_count' => $items->where('status', 'ACTIVE')->count(),
                'issue_count' => $items->whereIn('status', ['MAINTENANCE', 'DAMAGED', 'LOST'])->count(),
            ];
        });

        // Filter tipe jika dipilih
        if ($request->filled('type')) {
            $typeFilter = $request->get('type');
            if ($typeFilter === 'walas_meja') {
                $groups = $groups->filter(fn($g) => str_contains(strtoupper($g->code), 'WALAS') && !str_contains(strtoupper($g->code), 'PROY'));
            } elseif ($typeFilter === 'walas_proyektor') {
                $groups = $groups->filter(fn($g) => str_contains(strtoupper($g->code), 'PROY') || str_contains(strtoupper($g->name), 'PROYEKTOR'));
            } elseif ($typeFilter === 'lab') {
                $groups = $groups->filter(fn($g) => str_contains(strtoupper($g->code), 'LAB') || str_contains(strtoupper($g->code), 'WS'));
            }
        }

        // Aset mandiri yang belum masuk grup mana pun (untuk ditambahkan ke grup)
        $ungroupedAssets = Asset::where(function ($q) {
            $q->whereNull('group_code')->orWhere('group_code', '');
        })
        ->with(['location', 'assetItem'])
        ->orderBy('name')
        ->limit(200)
        ->get();

        $locations = Location::orderBy('name')->get();
        $placements = Placement::orderBy('name')->get();

        return view('asset-groups.index', compact(
            'groups',
            'ungroupedAssets',
            'locations',
            'placements'
        ));
    }

    /**
     * Buat grup meja / bundel perangkat baru atau masukkan aset ke grup.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_code' => ['required', 'string', 'max:50'],
            'group_name' => ['required', 'string', 'max:100'],
            'location_id' => ['nullable', 'exists:locations,id'],
            'asset_ids' => ['required', 'array', 'min:1'],
            'asset_ids.*' => ['exists:assets,id'],
            'primary_asset_id' => ['nullable', 'exists:assets,id'],
        ], [
            'group_code.required' => 'Kode grup meja / bundel wajib diisi.',
            'group_name.required' => 'Nama grup / meja wajib diisi.',
            'asset_ids.required' => 'Pilih setidaknya 1 perangkat untuk dimasukkan ke dalam grup ini.',
        ]);

        $groupCode = strtoupper(trim(str_replace(' ', '-', $validated['group_code'])));
        $groupName = trim($validated['group_name']);
        $primaryAssetId = $validated['primary_asset_id'] ?? $validated['asset_ids'][0];

        foreach ($validated['asset_ids'] as $assetId) {
            $isPrimary = ((int)$assetId === (int)$primaryAssetId);
            
            $updateData = [
                'group_code' => $groupCode,
                'group_name' => $groupName,
                'is_group_primary' => $isPrimary,
                'last_updated_by_user_id' => auth()->id(),
            ];

            if (!empty($validated['location_id'])) {
                $updateData['location_id'] = $validated['location_id'];
            }

            Asset::where('id', $assetId)->update($updateData);
        }

        return redirect()->route('asset-groups.index')
            ->with('success', "Grup Meja/Bundel [{$groupCode} — {$groupName}] berhasil dibuat dengan {$validated['asset_ids']} perangkat!");
    }

    /**
     * Perbarui data grup meja & anggota perangkatnya.
     */
    public function update(Request $request, string $groupCode)
    {
        $validated = $request->validate([
            'group_name' => ['required', 'string', 'max:100'],
            'primary_asset_id' => ['required', 'exists:assets,id'],
            'add_asset_ids' => ['nullable', 'array'],
            'add_asset_ids.*' => ['exists:assets,id'],
        ]);

        $groupName = trim($validated['group_name']);
        $primaryAssetId = (int) $validated['primary_asset_id'];

        // Update semua aset yang ada di grup ini
        Asset::where('group_code', $groupCode)->update([
            'group_name' => $groupName,
            'is_group_primary' => false,
            'last_updated_by_user_id' => auth()->id(),
        ]);

        // Tandai aset utama yang dipilih
        Asset::where('id', $primaryAssetId)->update([
            'is_group_primary' => true,
        ]);

        // Jika ada aset baru yang ditambahkan ke grup ini
        if (!empty($validated['add_asset_ids'])) {
            Asset::whereIn('id', $validated['add_asset_ids'])->update([
                'group_code' => $groupCode,
                'group_name' => $groupName,
                'is_group_primary' => false,
                'last_updated_by_user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('asset-groups.index')
            ->with('success', "Pengaturan grup meja [{$groupCode}] berhasil diperbarui!");
    }

    /**
     * Lepas satu aset dari grupnya.
     */
    public function detach(Request $request)
    {
        $request->validate([
            'asset_id' => ['required', 'exists:assets,id'],
        ]);

        $asset = Asset::findOrFail($request->input('asset_id'));
        $groupCode = $asset->group_code;

        $asset->update([
            'group_code' => null,
            'group_name' => null,
            'is_group_primary' => false,
            'last_updated_by_user_id' => auth()->id(),
        ]);

        // Jika aset yang dilepas adalah primary, jadikan aset lain di grup sebagai primary
        if ($groupCode) {
            $remaining = Asset::where('group_code', $groupCode)->first();
            if ($remaining && !Asset::where('group_code', $groupCode)->where('is_group_primary', true)->exists()) {
                $remaining->update(['is_group_primary' => true]);
            }
        }

        return redirect()->route('asset-groups.index')
            ->with('success', "Perangkat {$asset->name} ({$asset->asset_code}) berhasil dikeluarkan dari grup {$groupCode}.");
    }

    /**
     * Bubarkan seluruh grup meja.
     */
    public function destroy(string $groupCode)
    {
        $count = Asset::where('group_code', $groupCode)->count();

        Asset::where('group_code', $groupCode)->update([
            'group_code' => null,
            'group_name' => null,
            'is_group_primary' => false,
            'last_updated_by_user_id' => auth()->id(),
        ]);

        return redirect()->route('asset-groups.index')
            ->with('success', "Grup [{$groupCode}] berhasil dibubarkan. {$count} perangkat kini berstatus mandiri.");
    }
}
