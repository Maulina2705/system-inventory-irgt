<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maintenance_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('maintenance_reports', 'labour_cost')) {
                $table->decimal('labour_cost', 15, 2)->default(0)->after('technician_notes');
                $table->decimal('spare_part_cost', 15, 2)->default(0)->after('labour_cost');
                $table->decimal('other_cost', 15, 2)->default(0)->after('spare_part_cost');
                $table->decimal('total_cost', 15, 2)->default(0)->after('other_cost');
                $table->string('vendor_name')->nullable()->after('total_cost');
                $table->string('invoice_number', 100)->nullable()->after('vendor_name');
                $table->text('cost_notes')->nullable()->after('invoice_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('maintenance_reports', function (Blueprint $table) {
            $table->dropColumn([
                'labour_cost',
                'spare_part_cost',
                'other_cost',
                'total_cost',
                'vendor_name',
                'invoice_number',
                'cost_notes',
            ]);
        });
    }
};
