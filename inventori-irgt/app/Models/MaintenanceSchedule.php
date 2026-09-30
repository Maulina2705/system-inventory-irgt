<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceSchedule extends Model
{
    public const STATUS_UPCOMING = 'UPCOMING';
    public const STATUS_DUE = 'DUE';
    public const STATUS_OVERDUE = 'OVERDUE';
    public const STATUS_COMPLETED = 'COMPLETED';

    protected $fillable = [
        'asset_id',
        'maintenance_type',
        'interval_months',
        'last_maintenance',
        'next_maintenance',
        'assigned_to',
        'status',
        'checklist',
        'notes',
    ];

    protected $casts = [
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Accessors for backward compatibility
    public function getTitleAttribute(): string
    {
        return $this->maintenance_type ?? 'Perawatan Berkala';
    }

    public function getNextMaintenanceAtAttribute()
    {
        return $this->next_maintenance;
    }

    public function getLastMaintenanceAtAttribute()
    {
        return $this->last_maintenance;
    }

    public function getEffectiveStatusAttribute(): string
    {
        if ($this->status === self::STATUS_COMPLETED) {
            return self::STATUS_COMPLETED;
        }

        if (!$this->next_maintenance) {
            return self::STATUS_UPCOMING;
        }

        $today = Carbon::today();
        $next = Carbon::parse($this->next_maintenance);

        if ($next->isPast() && !$next->isToday()) {
            return self::STATUS_OVERDUE;
        }

        if ($next->isToday() || $next->diffInDays($today) <= 7) {
            return self::STATUS_DUE;
        }

        return self::STATUS_UPCOMING;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->effective_status) {
            self::STATUS_UPCOMING => 'Akan Datang',
            self::STATUS_DUE => 'Jatuh Tempo (Segera)',
            self::STATUS_OVERDUE => 'Terlambat (Overdue)',
            self::STATUS_COMPLETED => 'Selesai Dilakukan',
            default => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->effective_status) {
            self::STATUS_UPCOMING => 'bg-blue-100 text-blue-800 border-blue-300',
            self::STATUS_DUE => 'bg-amber-100 text-amber-800 border-amber-300',
            self::STATUS_OVERDUE => 'bg-rose-100 text-rose-800 border-rose-300',
            self::STATUS_COMPLETED => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            default => 'bg-slate-100 text-slate-800 border-slate-300',
        };
    }
}
