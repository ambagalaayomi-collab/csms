<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('technical_reports', function (Blueprint $table) {

            $table->decimal('material_cost', 12, 2)->default(0)->after('measurement_details');

            $table->decimal('labor_cost', 12, 2)->default(0)->after('material_cost');

            $table->decimal('equipment_cost', 12, 2)->default(0)->after('labor_cost');

            $table->string('estimated_duration')->nullable()->after('total_budget');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('technical_reports', function (Blueprint $table) {

            $table->dropColumn([
                'material_cost',
                'labor_cost',
                'equipment_cost',
                'estimated_duration'
                  ]);

        });
    }
};
