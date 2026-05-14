<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // In case a previous run partially created the table (migration failed),
        // recreate it cleanly. Safe because this is a new feature.
        Schema::dropIfExists('material_stock_reports');

        Schema::create('material_stock_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('item_id'); // cement/material item
            $table->date('report_date');
            $table->decimal('opening_balance', 12, 2)->default(0);
            $table->decimal('received_qty', 12, 2)->default(0);
            $table->decimal('consumed_qty', 12, 2)->default(0);
            $table->decimal('closing_balance', 12, 2)->default(0);
            $table->unsignedBigInteger('added_by');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['project_id', 'vendor_id', 'item_id', 'report_date', 'added_by'], 'msr_unique');
            // Explicit short name to avoid MySQL identifier limit
            $table->index(['project_id', 'vendor_id', 'item_id', 'report_date'], 'msr_pvid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_stock_reports');
    }
};

