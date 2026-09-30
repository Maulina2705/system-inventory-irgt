<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('maintenance_schedules')) {
            Schema::create('maintenance_schedules', function (Blueprint $table) {
                $table->id();

                $table->foreignId('asset_id')
                    ->constrained('assets')
                    ->cascadeOnDelete();

                $table->string('title');
                $table->string('maintenance_type'); // e.g. Cleaning dust, Thermal paste, Fan check, Lens cleaning, Firmware check
                $table->unsignedSmallInteger('interval_months')->default(3); // e.g. 3, 6, 12 months
                
                $table->date('last_maintenance_at')->nullable();
                $table->date('next_maintenance_at');

                $table->foreignId('assigned_to_user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->enum('status', [
                    'UPCOMING',
                    'DUE',
                    'OVERDUE',
                    'COMPLETED',
                ])->default('UPCOMING');

                $table->text('notes')->nullable();

                $table->timestamps();

                $table->index('asset_id');
                $table->index('status');
                $table->index('next_maintenance_at');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_schedules');
    }
};
