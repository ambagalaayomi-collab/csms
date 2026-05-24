<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_request_id')
                ->constrained('project_requests')
                ->onDelete('cascade');

            $table->foreignId('client_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('manager_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->text('proposal_details');
            $table->decimal('total_budget', 12, 2);
            $table->string('estimated_duration');
            $table->string('status')->default('Sent');
            $table->string('pdf_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};