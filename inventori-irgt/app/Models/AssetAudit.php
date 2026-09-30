<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetAudit extends Model
{
    protected $fillable = [
        'audit_code',
        'title',
        'audit_month',
        'audit_year',
        'location_id',
        'placement_id',
        'inspector_user_id',
        'inspector_name',
        'audit_date',
        'status',
        'summary_notes',
        'coordinator_name',
        'approved_at',
    ];

    protected $casts = [
        'audit_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function placement(): BelongsTo
    {
        return $this->belongsTo(Placement::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(AssetAuditItem::class, 'asset_audit_id');
    }
}
