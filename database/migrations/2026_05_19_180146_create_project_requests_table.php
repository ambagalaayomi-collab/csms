<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('project_requests')) {
            Schema::create('project_requests', function (Blueprint $table) {
                $table->id();

                $table->foreignId('client_id')
                      ->nullable()
                      ->constrained('users')
                      ->onDelete('cascade');

                $table->string('name');
                $table->string('phone');
                $table->string('email');
                $table->string('project_type');
                $table->string('location');
                $table->decimal('width', 10, 2);
                $table->decimal('height', 10, 2);
                $table->decimal('budget', 12, 2);
                $table->string('timeline');
                $table->text('requirements');
                $table->string('status')->default('Pending');
                $table->foreignId('assigned_engineer_id')->nullable()->constrained('users')->onDelete('set null');
                $table->date('due_date')->nullable();
                $table->string('status')->default('Pending');

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('project_requests');
    }
};