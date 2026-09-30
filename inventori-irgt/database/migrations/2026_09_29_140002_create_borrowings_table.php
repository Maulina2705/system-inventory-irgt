<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('borrowings')) {
            Schema::create('borrowings', function (Blueprint $table) {
                $table->id();

                $table->string('borrowing_code', 50)->unique();

                $table->foreignId('asset_id')
                    ->constrained('assets')
                    ->cascadeOnDelete();

                $table->string('borrower_name');
                $table->string('borrower_identifier')->nullable(); // NIP / NIS / Phone
                $table->string('department_class')->nullable(); // Departemen / Kelas
                $table->text('purpose')->nullable(); // Keperluan peminjaman

                $table->dateTime('borrowed_at');
                $table->dateTime('expected_return_at');
                $table->dateTime('returned_at')->nullable();

                $table->enum('status', [
                    'BORROWED',
                    'RETURNED',
                    'OVERDUE',
                    'LOST',
                    'DAMAGED',
                ])->default('BORROWED');

                $table->foreignId('approved_by_user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->text('notes')->nullable();

                $table->timestamps();

                $table->index('asset_id');
                $table->index('status');
                $table->index('borrowed_at');
                $table->index('expected_return_at');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
