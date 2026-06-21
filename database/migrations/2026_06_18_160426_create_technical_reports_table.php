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
        Schema::create('technical_reports', function (Blueprint $table) {
    $table->id('report_id'); // Primary Key
    $table->unsignedBigInteger('req_id'); // Foreign Key for Request
    $table->text('measurement_details');
    $table->decimal('total_budget', 15, 2); // For handling large currency amounts
    $table->string('duration');
    $table->date('date');
    $table->timestamps();

    // Relationship එකක් තියෙනවා නම්:
    // $table->foreign('req_id')->references('id')->on('requests')->onDelete('cascade');
});
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_reports');
    }
};
