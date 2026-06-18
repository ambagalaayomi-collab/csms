<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_requests', function (Blueprint $table) {
        if (!Schema::hasColumn('project_requests', 'width')) {
            $table->decimal('width', 10, 2)->nullable()->after('location');
        }

        if (!Schema::hasColumn('project_requests', 'height')) {
            $table->decimal('height', 10, 2)->nullable()->after('width');
        }
        });
    }

    public function down(): void
    {
        Schema::table('project_requests', function (Blueprint $table) {
            $table->dropColumn(['width', 'height']);
        });
    }
};