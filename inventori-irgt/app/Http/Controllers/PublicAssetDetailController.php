<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\View\View;

class PublicAssetDetailController extends Controller
{
    /**
     * Halaman publik detail aset yang muncul saat QR Code discan.
     */
    public function scan(string $token): View
    {
        $asset = Asset::where('qr_token', $token)
            ->with(['placement', 'location', 'assetType', 'assetItem'])
            ->firstOrFail();

        $groupAssets = collect();
        if ($asset->group_code) {
            $groupAssets = Asset::where('group_code', $asset->group_code)
                ->with(['assetType', 'assetItem'])
                ->orderByRaw("FIELD(asset_item_id, (SELECT id FROM asset_items WHERE code = 'PC'), (SELECT id FROM asset_items WHERE code = 'MN'), (SELECT id FROM asset_items WHERE code = 'KY'), (SELECT id FROM asset_items WHERE code = 'MO'), (SELECT id FROM asset_items WHERE code = 'SP')) ASC")
                ->get();
        }

        return view('scan.show', compact('asset', 'groupAssets'));
    }
}
