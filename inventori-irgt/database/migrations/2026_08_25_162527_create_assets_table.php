<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {

            $table->id();

            // =========================
            // IDENTITAS INVENTARIS
            // =========================

            $table->string('asset_code')->unique();

            $table->unsignedSmallInteger('inventory_year');

            $table->unsignedInteger('sequence_number');

            // =========================
            // KODE INVENTARIS
            // =========================

            $table->foreignId('placement_id')
                ->constrained('placements')
                ->restrictOnDelete();

            $table->foreignId('location_id')
                ->constrained('locations')
                ->restrictOnDelete();

            $table->foreignId('asset_type_id')
                ->constrained('asset_types')
                ->restrictOnDelete();

            $table->foreignId('asset_item_id')
                ->constrained('asset_items')
                ->restrictOnDelete();

            // =========================
            // INFORMASI PERANGKAT
            // =========================

            $table->string('name');

            $table->string('brand')->nullable();

            $table->string('model')->nullable();

            $table->string('serial_number')
                ->nullable()
                ->unique();

            // =========================
            // KEPEMILIKAN
            // =========================

            $table->string('ownership')
                ->default('IRGT School');

            $table->string('assigned_to')
                ->nullable();

            // =========================
            // STATUS
            // =========================

            $table->enum('status', [
                'ACTIVE',
                'MAINTENANCE',
                'DAMAGED',
                'LOST',
                'RETIRED',
            ])->default('ACTIVE');

            $table->enum('condition', [
                'GOOD',
                'FAIR',
                'POOR',
                'DAMAGED',
            ])->default('GOOD');

            // =========================
            // PEMBELIAN
            // =========================

            $table->date('purchase_date')
                ->nullable();

            $table->string('vendor')
                ->nullable();

            $table->date('warranty_expiry')
                ->nullable();

            // =========================
            // NETWORK
            // =========================

            $table->ipAddress('ip_address')
                ->nullable();

            $table->string('mac_address')
                ->nullable();

            // =========================
            // QR CODE
            // =========================

            $table->string('qr_token')
                ->unique();

            // =========================
            // CATATAN
            // =========================

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            // =========================
            // INDEX
            // =========================

            $table->index('status');
            $table->index('condition');
            $table->index('inventory_year');

            // Mencegah nomor urut yang sama
            // untuk kombinasi kode inventaris + tahun
            $table->unique([
                'placement_id',
                'location_id',
                'asset_type_id',
                'asset_item_id',
                'inventory_year',
                'sequence_number'
            ], 'asset_sequence_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};