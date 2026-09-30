<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CctvCheck extends Model
{
    protected $fillable = [
        'asset_id',
        'checked_by_user_id',
        'inspector_name',
        'check_date',
        'network_status',
        'ip_address',
        'ping_ms',
        'stream_status',
        'physical_condition',
        'night_vision_status',
        'ptz_function',
        'storage_type',
        'storage_status',
        'storage_capacity_gb',
        'days_retained',
        'overall_verdict',
        'notes',
    ];

    protected $casts = [
        'check_date' => 'date',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_by_user_id');
    }
}
