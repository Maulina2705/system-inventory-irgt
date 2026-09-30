<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    protected $fillable = [
        'asset_code',
        'inventory_year',
        'sequence_number',

        'placement_id',
        'location_id',
        'asset_type_id',
        'asset_item_id',

        'name',
        'brand',
        'model',
        'specifications',
        'serial_number',

        'group_code',
        'group_name',
        'is_group_primary',

        'ownership',
        'assigned_to',

        'status',
        'condition',

        'purchase_date',
        'vendor',
        'warranty_expiry',

        'ip_address',
        'mac_address',

        'qr_token',

        'notes',

        'created_by_user_id',
        'last_updated_by_user_id',
        'last_solved_by_user_id',
        'last_solved_at',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
        'last_solved_at' => 'datetime',
        'is_group_primary' => 'boolean',
        'specifications' => 'array',
    ];

    public function placement(): BelongsTo
    {
        return $this->belongsTo(Placement::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function assetType(): BelongsTo
    {
        return $this->belongsTo(AssetType::class);
    }

    public function assetItem(): BelongsTo
    {
        return $this->belongsTo(AssetItem::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_updated_by_user_id');
    }

    public function solver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_solved_by_user_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(AssetHistory::class)->orderBy('id', 'desc');
    }

    public function maintenanceReports(): HasMany
    {
        return $this->hasMany(MaintenanceReport::class)->orderBy('id', 'desc');
    }

    public function groupMembers(): HasMany
    {
        return $this->hasMany(Asset::class, 'group_code', 'group_code');
    }

    public function cctvChecks(): HasMany
    {
        return $this->hasMany(CctvCheck::class)->orderBy('check_date', 'desc');
    }

    public function auditItems(): HasMany
    {
        return $this->hasMany(AssetAuditItem::class);
    }

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class)->orderBy('id', 'desc');
    }

    public function activeBorrowing()
    {
        return $this->hasOne(Borrowing::class)->where('status', 'BORROWED')->latest();
    }

    public function maintenanceSchedules(): HasMany
    {
        return $this->hasMany(MaintenanceSchedule::class)->orderBy('next_maintenance_at', 'asc');
    }
}