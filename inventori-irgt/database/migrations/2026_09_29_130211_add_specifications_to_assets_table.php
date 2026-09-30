<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'specifications')) {
                $table->json('specifications')->nullable()->after('model');
            }
        });

        // Add 'BORROWED' to status enum if on MySQL
        try {
            DB::statement("ALTER TABLE assets MODIFY COLUMN status ENUM('ACTIVE', 'MAINTENANCE', 'DAMAGED', 'LOST', 'RETIRED', 'BORROWED') NOT NULL DEFAULT 'ACTIVE'");
        } catch (\Throwable $e) {
            // Fallback / SQLite / etc
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            if (Schema::hasColumn('assets', 'specifications')) {
                $table->dropColumn('specifications');
            }
        });

        try {
            DB::statement("ALTER TABLE assets MODIFY COLUMN status ENUM('ACTIVE', 'MAINTENANCE', 'DAMAGED', 'LOST', 'RETIRED') NOT NULL DEFAULT 'ACTIVE'");
        } catch (\Throwable $e) {
            // Fallback
        }
    }
};
