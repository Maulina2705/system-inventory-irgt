<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('maintenance_reports', function (Blueprint $table) {
            // Ubah user_id menjadi nullable agar pelapor publik bisa membuat laporan tanpa login
            $table->foreignId('user_id')->nullable()->change();

            // Tambah kolom departemen pelapor jika belum ada
            if (!Schema::hasColumn('maintenance_reports', 'reporter_department')) {
                $table->string('reporter_department', 100)->nullable()->after('reporter_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_reports', function (Blueprint $table) {
            if (Schema::hasColumn('maintenance_reports', 'reporter_department')) {
                $table->dropColumn('reporter_department');
            }
        });
    }
};
