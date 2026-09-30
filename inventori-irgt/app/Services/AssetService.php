<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\Placement;
use App\Models\Location;
use App\Models\AssetType;
use App\Models\AssetItem;
use Illuminate\Support\Str;

class AssetService
{
    public function create(
        Placement $placement,
        Location $location,
        AssetType $assetType,
        AssetItem $assetItem,
        string $name,
        int $year,
        array $data = []
    ): Asset {
        $codeGenerator = new AssetCodeGenerator();

        $lastSequence = Asset::where('placement_id', $placement->id)
            ->where('location_id', $location->id)
            ->where('asset_type_id', $assetType->id)
            ->where('asset_item_id', $assetItem->id)
            ->where('inventory_year', $year)
            ->max('sequence_number');

        $sequenceNumber = ($lastSequence ?? 0) + 1;

        $assetCode = $codeGenerator->generate(
            $placement,
            $location,
            $assetType,
            $assetItem,
            $year
        );

        $userId = auth()->id() ?? null;
        $userName = auth()->user()->name ?? 'Petugas';

        $asset = Asset::create([
            'asset_code' => $assetCode,
            'inventory_year' => $year,
            'sequence_number' => $sequenceNumber,

            'placement_id' => $placement->id,
            'location_id' => $location->id,
            'asset_type_id' => $assetType->id,
            'asset_item_id' => $assetItem->id,

            'name' => $name,

            'ownership' => $data['ownership'] ?? 'IRGT School',
            'assigned_to' => $data['assigned_to'] ?? null,

            'brand' => $data['brand'] ?? null,
            'model' => $data['model'] ?? null,
            'specifications' => $data['specifications'] ?? null,
            'serial_number' => $data['serial_number'] ?? null,

            'group_code' => $data['group_code'] ?? null,
            'group_name' => $data['group_name'] ?? null,
            'is_group_primary' => (bool)($data['is_group_primary'] ?? false),

            'status' => $data['status'] ?? 'ACTIVE',
            'condition' => $data['condition'] ?? 'GOOD',

            'purchase_date' => $data['purchase_date'] ?? null,
            'vendor' => $data['vendor'] ?? null,
            'warranty_expiry' => $data['warranty_expiry'] ?? null,

            'ip_address' => $data['ip_address'] ?? null,
            'mac_address' => $data['mac_address'] ?? null,

            'qr_token' => Str::random(32),

            'notes' => $data['notes'] ?? null,

            'created_by_user_id' => $userId,
            'last_updated_by_user_id' => $userId,
        ]);

        // Catat log histori awal
        AssetHistory::create([
            'asset_id' => $asset->id,
            'user_id' => $userId,
            'action' => 'CREATED',
            'new_status' => $asset->status,
            'notes' => "Aset pertama kali didaftarkan ke sistem oleh {$userName}",
        ]);

        return $asset;
    }
}