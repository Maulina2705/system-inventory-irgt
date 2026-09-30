<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('group_code', 50)->nullable()->after('serial_number')->index();
            $table->string('group_name', 100)->nullable()->after('group_code');
            $table->boolean('is_group_primary')->default(false)->after('group_name');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['group_code', 'group_name', 'is_group_primary']);
        });
    }
};
