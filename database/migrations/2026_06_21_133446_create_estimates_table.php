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
        Schema::create('estimates', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_request_id')->constrained()->onDelete('cascade');
    $table->foreignId('engineer_id')->constrained('users')->onDelete('cascade');

    // Material columns
    $table->decimal('cement_qty', 10, 2);
    $table->decimal('cement_cost', 10, 2);
    $table->decimal('sand_qty', 10, 2);
    $table->decimal('sand_cost', 10, 2);
    $table->decimal('steel_qty', 10, 2);
    $table->decimal('steel_cost', 10, 2);
    $table->decimal('brick_qty', 10, 2);
    $table->decimal('brick_cost', 10, 2);

    // Labor columns
    $table->decimal('mason_qty', 10, 2);
    $table->decimal('mason_cost', 10, 2);
    $table->decimal('carpenter_qty', 10, 2);
    $table->decimal('carpenter_cost', 10, 2);
    // $table->decimal('helper_qty', 10, 2);
    // $table->decimal('helper_cost', 10, 2);

    // Equipment columns
    $table->decimal('mixer_qty', 10, 2);
    $table->decimal('mixer_cost', 10, 2);
    $table->decimal('excavator_qty', 10, 2);
    $table->decimal('excavator_cost', 10, 2);
    $table->decimal('truck_qty', 10, 2);
    $table->decimal('truck_cost', 10, 2);

    // Other details
    $table->string('estimated_duration');
    $table->text('remarks')->nullable();
    $table->string('status')->default('Pending');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
