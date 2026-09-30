<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class MaintenanceReport extends Model
{
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    public const STATUS_RESOLVED = 'RESOLVED';
    public const STATUS_REJECTED = 'REJECTED';

    public const PRIORITY_LOW = 'LOW';
    public const PRIORITY_MEDIUM = 'MEDIUM';
    public const PRIORITY_HIGH = 'HIGH';
    public const PRIORITY_EMERGENCY = 'EMERGENCY';

    public const DEPARTMENTS = [
        'Guru' => 'Guru',
        'IT Departement' => 'IT Departement',
        'Primary Principal' => 'Primary Principal',
        'Secondary Principal' => 'Secondary Principal',
        'Administration Departement' => 'Administration Departement',
        'Finance Departement' => 'Finance Departement',
        'Other Departement' => 'Other Departement',
    ];

    protected $fillable = [
        'report_number',
        'asset_id',
        'user_id',
        'reporter_name',
        'reporter_department',
        'reporter_phone',
        'title',
        'description',
        'priority',
        'photo_path',
        'status',
        'handled_by_user_id',
        'technician_notes',
        'labour_cost',
        'spare_part_cost',
        'other_cost',
        'total_cost',
        'vendor_name',
        'invoice_number',
        'cost_notes',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'labour_cost' => 'float',
        'spare_part_cost' => 'float',
        'other_cost' => 'float',
        'total_cost' => 'float',
    ];

    protected static function booted()
    {
        static::saving(function ($report) {
            $report->total_cost = (float)($report->labour_cost ?? 0) + (float)($report->spare_part_cost ?? 0) + (float)($report->other_cost ?? 0);
        });
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by_user_id');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo_path) {
            return null;
        }

        return Storage::disk('public')->url($this->photo_path);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Respon',
            self::STATUS_IN_PROGRESS => 'Sedang Dikerjakan',
            self::STATUS_RESOLVED => 'Selesai Diperbaiki',
            self::STATUS_REJECTED => 'Ditolak / Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'badge-pending',
            self::STATUS_IN_PROGRESS => 'badge-in-progress',
            self::STATUS_RESOLVED => 'badge-resolved',
            self::STATUS_REJECTED => 'badge-rejected',
            default => 'badge-pending',
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            self::PRIORITY_LOW => 'Rendah (Low)',
            self::PRIORITY_MEDIUM => 'Sedang (Medium)',
            self::PRIORITY_HIGH => 'Tinggi (High)',
            self::PRIORITY_EMERGENCY => 'Darurat (Emergency)',
            default => $this->priority,
        };
    }

    public function getPriorityBadgeClassAttribute(): string
    {
        return match ($this->priority) {
            self::PRIORITY_LOW => 'badge-pri-low',
            self::PRIORITY_MEDIUM => 'badge-pri-medium',
            self::PRIORITY_HIGH => 'badge-pri-high',
            self::PRIORITY_EMERGENCY => 'badge-pri-emergency',
            default => 'badge-pri-medium',
        };
    }

    public function getFormattedTotalCostAttribute(): string
    {
        return 'Rp ' . number_format($this->total_cost ?? 0, 0, ',', '.');
    }

    public function getFormattedLabourCostAttribute(): string
    {
        return 'Rp ' . number_format($this->labour_cost ?? 0, 0, ',', '.');
    }

    public function getFormattedSparePartCostAttribute(): string
    {
        return 'Rp ' . number_format($this->spare_part_cost ?? 0, 0, ',', '.');
    }

    public function getFormattedOtherCostAttribute(): string
    {
        return 'Rp ' . number_format($this->other_cost ?? 0, 0, ',', '.');
    }
}
