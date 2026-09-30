<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting by key with optional default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("system_setting_{$key}", 300, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting key-value pair.
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => is_bool($value) ? ($value ? '1' : '0') : $value]
        );

        Cache::forget("system_setting_{$key}");
    }

    /**
     * Check if System Recovery / Maintenance Mode is currently active.
     */
    public static function isRecoveryMode(): bool
    {
        return (string) static::get('recovery_mode_enabled', '0') === '1';
    }

    /**
     * Get recovery mode details for display.
     */
    public static function getRecoveryDetails(): array
    {
        return [
            'is_active' => static::isRecoveryMode(),
            'title' => static::get('recovery_mode_title', 'Website Sedang Dalam Pemulihan oleh Tim IT IRGT'),
            'message' => static::get('recovery_mode_message', 'Sistem Inventaris dan Manajemen Infrastruktur IRGT School sedang dalam tahap pemeliharaan rutin dan optimalisasi database oleh tim IT.'),
            'estimated_end' => static::get('recovery_mode_estimated_end', null),
            'activated_by' => static::get('recovery_mode_activated_by', null),
        ];
    }
}
