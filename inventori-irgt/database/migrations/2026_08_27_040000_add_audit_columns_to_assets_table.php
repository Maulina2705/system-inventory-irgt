<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('assets', 'created_by_user_id')) {
            Schema::table('assets', function (Blueprint $table) {
                $table->foreignId('created_by_user_id')
                    ->nullable()
                    ->after('notes')
                    ->constrained('users')
                    ->nullOnDelete();

                $table->foreignId('last_updated_by_user_id')
                    ->nullable()
                    ->after('created_by_user_id')
                    ->constrained('users')
                    ->nullOnDelete();

                $table->foreignId('last_solved_by_user_id')
                    ->nullable()
                    ->after('last_updated_by_user_id')
                    ->constrained('users')
                    ->nullOnDelete();

                $table->timestamp('last_solved_at')
                    ->nullable()
                    ->after('last_solved_by_user_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by_user_id');
            $table->dropConstrainedForeignId('last_updated_by_user_id');
            $table->dropConstrainedForeignId('last_solved_by_user_id');
            $table->dropColumn('last_solved_at');
        });
    }
};
