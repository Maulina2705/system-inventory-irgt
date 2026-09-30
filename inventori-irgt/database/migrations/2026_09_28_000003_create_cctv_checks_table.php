<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cctv_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->foreignId('checked_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('inspector_name')->nullable();
            $table->date('check_date');
            
            // 1. Pemeriksaan Jaringan & Koneksi
            $table->enum('network_status', ['ONLINE', 'OFFLINE', 'UNSTABLE'])->default('ONLINE');
            $table->string('ip_address')->nullable();
            $table->integer('ping_ms')->nullable();
            $table->enum('stream_status', ['OK', 'NO_VIDEO', 'LAG', 'FLICKER'])->default('OK');

            // 2. Pemeriksaan Fisik & Optik
            $table->enum('physical_condition', ['CLEAN', 'DIRTY_LENS', 'BLURRY', 'WATER_DAMAGE', 'LOOSE_BRACKET', 'DAMAGED'])->default('CLEAN');
            $table->enum('night_vision_status', ['OK', 'FAIL', 'NOT_APPLICABLE'])->default('OK');
            $table->enum('ptz_function', ['NORMAL', 'STUCK', 'NOT_APPLICABLE'])->default('NOT_APPLICABLE');

            // 3. Pemeriksaan Memori & Rekaman
            $table->enum('storage_type', ['SD_CARD', 'NVR_HDD', 'CLOUD', 'NONE'])->default('NVR_HDD');
            $table->enum('storage_status', ['RECORDING_NORMAL', 'OVERFLOW_ERROR', 'CORRUPT', 'NO_STORAGE', 'UNFORMATTED'])->default('RECORDING_NORMAL');
            $table->unsignedSmallInteger('storage_capacity_gb')->nullable();
            $table->unsignedSmallInteger('days_retained')->nullable();

            // Kesimpulan & Catatan
            $table->enum('overall_verdict', ['NORMAL', 'NEED_MAINTENANCE', 'REPLACE_DEVICE'])->default('NORMAL');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cctv_checks');
    }
};
