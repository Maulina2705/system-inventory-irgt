<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\Placement;
use App\Models\Location;
use App\Models\AssetType;
use App\Models\AssetItem;

class AssetCodeGenerator
{
    public function generate(
        Placement $placement,
        Location $location,
        AssetType $assetType,
        AssetItem $assetItem,
        int $year
    ): string {
        $prefix = sprintf(
            'INV-%s%s%s%s-%d',
            $placement->code,
            $location->code,
            $assetType->code,
            $assetItem->code,
            $year
        );

        $lastSequence = Asset::where('placement_id', $placement->id)
            ->where('location_id', $location->id)
            ->where('asset_type_id', $assetType->id)
            ->where('asset_item_id', $assetItem->id)
            ->where('inventory_year', $year)
            ->max('sequence_number');

        $nextSequence = ($lastSequence ?? 0) + 1;

        return sprintf(
            '%s-%03d',
            $prefix,
            $nextSequence
        );
    }
}