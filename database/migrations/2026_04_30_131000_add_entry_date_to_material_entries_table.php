<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('material_entries', function (Blueprint $table) {
            if (! Schema::hasColumn('material_entries', 'entry_date')) {
                $table->date('entry_date')->nullable()->after('project_id');
            }
        });

        // Backfill for existing rows so reports work for past entries.
        DB::statement("UPDATE material_entries SET entry_date = DATE(created_at) WHERE entry_date IS NULL");
    }

    public function down(): void
    {
        Schema::table('material_entries', function (Blueprint $table) {
            if (Schema::hasColumn('material_entries', 'entry_date')) {
                $table->dropColumn('entry_date');
            }
        });
    }
};

