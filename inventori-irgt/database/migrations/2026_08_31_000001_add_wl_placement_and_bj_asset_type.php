<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah Penempatan WL (Wali Kelas)
        if (!DB::table('placements')->where('code', 'WL')->exists()) {
            DB::table('placements')->insert([
                'code' => 'WL',
                'name' => 'Wali Kelas',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Tambah Jenis Barang BJ (Pembelajaran)
        if (!DB::table('asset_types')->where('code', 'BJ')->exists()) {
            DB::table('asset_types')->insert([
                'code' => 'BJ',
                'name' => 'Pembelajaran',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('placements')->where('code', 'WL')->delete();
        DB::table('asset_types')->where('code', 'BJ')->delete();
    }
};
