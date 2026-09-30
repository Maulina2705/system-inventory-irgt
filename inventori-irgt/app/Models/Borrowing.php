<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing extends Model
{
    public const STATUS_PENDING_APPROVAL = 'PENDING_APPROVAL';
    public const STATUS_BORROWED = 'BORROWED';
    public const STATUS_RETURNED = 'RETURNED';
    public const STATUS_OVERDUE = 'OVERDUE';
    public const STATUS_LOST = 'LOST';
    public const STATUS_DAMAGED = 'DAMAGED';
    public const STATUS_REJECTED = 'REJECTED';

    protected $fillable = [
        'borrowing_code',
        'asset_id',
        'borrower_name',
        'borrower_identifier',
        'department',
        'purpose',
        'borrowed_at',
        'expected_return_at',
        'returned_at',
        'status',
        'approved_by',
        'notes',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'expected_return_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getDepartmentClassAttribute()
    {
        return $this->department;
    }

    public function setDepartmentClassAttribute($value)
    {
        $this->attributes['department'] = $value;
    }

    public function getIsOverdueAttribute(): bool
    {
        if ($this->status === self::STATUS_RETURNED) {
            return false;
        }

        if (!$this->expected_return_at) {
            return false;
        }

        return $this->expected_return_at->isPast();
    }

    public function getEffectiveStatusAttribute(): string
    {
        if ($this->status === self::STATUS_BORROWED && $this->is_overdue) {
            return self::STATUS_OVERDUE;
        }

        return $this->status;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->effective_status) {
            self::STATUS_PENDING_APPROVAL => 'Menunggu Persetujuan',
            self::STATUS_BORROWED => 'Sedang Dipinjam',
            self::STATUS_RETURNED => 'Sudah Dikembalikan',
            self::STATUS_OVERDUE => 'Terlambat Kembali',
            self::STATUS_LOST => 'Hilang',
            self::STATUS_DAMAGED => 'Rusak Saat Dipinjam',
            self::STATUS_REJECTED => 'Pengajuan Ditolak',
            default => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->effective_status) {
            self::STATUS_BORROWED => 'bg-amber-100 text-amber-800 border-amber-300',
            self::STATUS_RETURNED => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            self::STATUS_OVERDUE => 'bg-rose-100 text-rose-800 border-rose-300',
            self::STATUS_LOST => 'bg-zinc-800 text-white border-zinc-900',
            self::STATUS_DAMAGED => 'bg-red-100 text-red-800 border-red-300',
            default => 'bg-slate-100 text-slate-800 border-slate-300',
        };
    }
}
