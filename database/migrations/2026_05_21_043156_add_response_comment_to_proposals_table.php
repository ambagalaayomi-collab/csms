<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('proposals', 'response_comment')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->text('response_comment')->nullable()->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('proposals', 'response_comment')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->dropColumn('response_comment');
            });
        }
    }
};
