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
        Schema::create('stock_report_edit_histories', function (Blueprint $table) {
            $table->id();
               $table->unsignedBigInteger('stock_report_id');

    $table->text('reason');

    $table->decimal('old_opening_balance', 10, 2)->nullable();

    $table->decimal('old_received', 10, 2)->nullable();

    $table->decimal('old_used', 10, 2)->nullable();

    $table->decimal('old_balance', 10, 2)->nullable();

    $table->unsignedBigInteger('edited_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_report_edit_histories');
    }
};
