<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('system_settings')) {
            Schema::create('system_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });

            // Insert initial default recovery mode settings
            DB::table('system_settings')->insert([
                [
                    'key' => 'recovery_mode_enabled',
                    'value' => '0',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key' => 'recovery_mode_title',
                    'value' => 'Website Sedang Dalam Pemulihan oleh Tim IT IRGT',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key' => 'recovery_mode_message',
                    'value' => 'Sistem Inventaris dan Manajemen Infrastruktur IRGT School sedang dalam tahap pemeliharaan rutin dan optimalisasi database oleh tim IT.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key' => 'recovery_mode_estimated_end',
                    'value' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key' => 'recovery_mode_activated_by',
                    'value' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
