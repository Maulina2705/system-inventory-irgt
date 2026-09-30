<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('asset_histories_archive')) {
            Schema::create('asset_histories_archive', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('asset_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();

                $table->string('action', 50);
                $table->string('old_status', 30)->nullable();
                $table->string('new_status', 30)->nullable();
                $table->text('notes')->nullable();

                $table->timestamp('original_created_at')->nullable();
                $table->timestamp('original_updated_at')->nullable();
                $table->timestamp('archived_at')->useCurrent();

                $table->index('asset_id');
                $table->index('user_id');
                $table->index('action');
                $table->index('archived_at');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_histories_archive');
    }
};
