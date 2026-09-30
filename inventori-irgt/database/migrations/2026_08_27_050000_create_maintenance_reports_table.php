<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('maintenance_reports')) {
            Schema::create('maintenance_reports', function (Blueprint $table) {
                $table->id();

                // Nomor Laporan Unik (misal: REP-20260827-0001)
                $table->string('report_number', 50)->unique();

                // Relasi ke Aset yang dilaporkan
                $table->foreignId('asset_id')
                    ->constrained('assets')
                    ->cascadeOnDelete();

                // User yang membuat laporan
                $table->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete();

                // Snapshot identitas pelapor
                $table->string('reporter_name');
                $table->string('reporter_phone', 50)->nullable();

                // Informasi Kerusakan
                $table->string('title');
                $table->text('description');

                // Tingkat Keparahan / Urgensi
                $table->enum('priority', [
                    'LOW',
                    'MEDIUM',
                    'HIGH',
                    'EMERGENCY',
                ])->default('MEDIUM');

                // Foto bukti kendala (opsional)
                $table->string('photo_path')->nullable();

                // Status Pengerjaan Tiket Laporan
                $table->enum('status', [
                    'PENDING',      // Baru diajukan oleh user, menunggu respon IT
                    'IN_PROGRESS',  // Sedang dikerjakan oleh teknisi IT
                    'RESOLVED',     // Selesai diperbaiki
                    'REJECTED',     // Ditolak / Dibatalkan
                ])->default('PENDING');

                // Petugas IT yang menangani
                $table->foreignId('handled_by_user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                // Catatan tindakan perbaikan / alasan penolakan teknisi
                $table->text('technician_notes')->nullable();

                // Waktu perbaikan selesai
                $table->timestamp('resolved_at')->nullable();

                $table->timestamps();

                // Indexing
                $table->index('asset_id');
                $table->index('user_id');
                $table->index('status');
                $table->index('priority');
                $table->index('handled_by_user_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_reports');
    }
};
