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
            $table->decimal('length', 10, 2)->nullable()->after('req_id');
            $table->decimal('width', 10, 2)->nullable()->after('length');
            $table->decimal('area', 10, 2)->nullable()->after('width');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('technical_reports', function (Blueprint $table) {
            $table->dropColumn(['length', 'width', 'area']);
        });
    }
};
