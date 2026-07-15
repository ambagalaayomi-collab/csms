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
        $table->dropColumn('measurement_details');
    });
}

public function down(): void
{
    Schema::table('technical_reports', function (Blueprint $table) {
        $table->text('measurement_details')->nullable(); // කලින් තිබ්බ data type එකක් දෙන්න
    });
}
};
