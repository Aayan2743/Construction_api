<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            if (! Schema::hasColumn('expenses', 'labour_id')) {
                $table->unsignedBigInteger('labour_id')->nullable()->after('vendor_id');
                $table->foreign('labour_id')->references('id')->on('labours')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            if (Schema::hasColumn('expenses', 'labour_id')) {
                $table->dropForeign(['labour_id']);
                $table->dropColumn('labour_id');
            }
        });
    }
};

