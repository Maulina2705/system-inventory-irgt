<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_audits', function (Blueprint $table) {
            $table->id();
            $table->string('audit_code', 50)->unique();
            $table->string('title');
            $table->unsignedTinyInteger('audit_month');
            $table->unsignedSmallInteger('audit_year');
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('placement_id')->nullable()->constrained('placements')->nullOnDelete();
            $table->foreignId('inspector_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('inspector_name')->nullable();
            $table->date('audit_date');
            $table->enum('status', ['DRAFT', 'COMPLETED'])->default('DRAFT');
            $table->text('summary_notes')->nullable();
            $table->string('coordinator_name')->default('Koordinator Labor Komputer IRGT School');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('asset_audit_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_audit_id')->constrained('asset_audits')->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->enum('condition', ['GOOD', 'FAIR', 'POOR', 'DAMAGED'])->default('GOOD');
            $table->enum('status', ['ACTIVE', 'MAINTENANCE', 'DAMAGED', 'LOST', 'RETIRED'])->default('ACTIVE');
            $table->string('physical_check_status', 50)->default('NORMAL');
            $table->text('notes')->nullable();
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_audit_items');
        Schema::dropIfExists('asset_audits');
    }
};
