<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('asset_histories')) {
            Schema::create('asset_histories', function (Blueprint $table) {
                $table->id();

                $table->foreignId('asset_id')
                    ->constrained('assets')
                    ->cascadeOnDelete();

                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->string('action', 50); // CREATED, UPDATED, STATUS_CHANGED, MAINTENANCE_REPORTED, REPAIR_SOLVED
                $table->string('old_status', 30)->nullable();
                $table->string('new_status', 30)->nullable();
                $table->text('notes')->nullable();

                $table->timestamps();

                $table->index('asset_id');
                $table->index('user_id');
                $table->index('action');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_histories');
    }
};
