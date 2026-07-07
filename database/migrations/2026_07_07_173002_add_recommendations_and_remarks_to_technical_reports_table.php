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

            $table->text('recommendations')->nullable()->after('estimated_duration');

            $table->text('remarks')->nullable()->after('recommendations');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('technical_reports', function (Blueprint $table) {

            $table->dropColumn([
                'recommendations',
                'remarks'
            ]);
        });
    }
};
