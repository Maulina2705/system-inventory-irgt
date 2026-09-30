<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetHistoryArchive extends Model
{
    protected $table = 'asset_histories_archive';

    public $timestamps = false;

    protected $fillable = [
        'asset_id',
        'user_id',
        'action',
        'old_status',
        'new_status',
        'notes',
        'original_created_at',
        'original_updated_at',
        'archived_at',
    ];

    protected $casts = [
        'original_created_at' => 'datetime',
        'original_updated_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
