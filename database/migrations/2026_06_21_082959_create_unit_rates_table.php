<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('unit_rates', function (Blueprint $table) {
        $table->id();
        $table->string('item_key')->unique(); // උදා: cement, sand, steel
        $table->string('item_name');         // උදා: Cement, Sand
        $table->string('unit');              // උදා: Bags, Cubes
        $table->decimal('rate', 10, 2);      // උදා: 2300.00
        $table->timestamps();
        
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_rates');
    }
};
