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
        $table->string('cost_estimate_file')
            ->nullable()
            ->after('area');
    });
}

public function down(): void
{
    Schema::table('technical_reports', function (Blueprint $table) {
        $table->dropColumn('cost_estimate_file');
    });
}
};
