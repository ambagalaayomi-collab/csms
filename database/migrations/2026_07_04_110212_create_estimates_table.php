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
        
        // Material Costs
        $table->decimal('cement_qty', 10, 2)->default(0);
        $table->decimal('cement_cost', 12, 2)->default(0);
        $table->decimal('sand_qty', 10, 2)->default(0);
        $table->decimal('sand_cost', 12, 2)->default(0);
        $table->decimal('steel_qty', 10, 2)->default(0);
        $table->decimal('steel_cost', 12, 2)->default(0);
        $table->decimal('brick_qty', 10, 2)->default(0);
        $table->decimal('brick_cost', 12, 2)->default(0);
        
        // Labor Costs
        $table->decimal('mason_qty', 10, 2)->default(0);
        $table->decimal('mason_cost', 12, 2)->default(0);
        $table->decimal('carpenter_qty', 10, 2)->default(0);
        $table->decimal('carpenter_cost', 12, 2)->default(0);
        $table->decimal('helper_qty', 10, 2)->default(0);
        $table->decimal('helper_cost', 12, 2)->default(0);
        
        // Equipment Costs
        $table->decimal('mixer_qty', 10, 2)->default(0);
        $table->decimal('mixer_cost', 12, 2)->default(0);
        $table->decimal('excavator_qty', 10, 2)->default(0);
        $table->decimal('excavator_cost', 12, 2)->default(0);
        $table->decimal('truck_qty', 10, 2)->default(0);
        $table->decimal('truck_cost', 12, 2)->default(0);
        
        $table->string('estimated_duration');
        $table->text('remarks')->nullable();
        
        
        $table->decimal('grand_total', 15, 2)->default(0.00); 
        
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
