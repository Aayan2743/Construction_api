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
        Schema::create('stock_reports', function (Blueprint $table) {
            $table->id();

             $table->date('date');

    $table->unsignedBigInteger('item_id');

    $table->unsignedBigInteger('vendor_id')->nullable();

    $table->decimal('opening_balance', 10, 2)->default(0);

    $table->decimal('received', 10, 2)->default(0);

    $table->decimal('used', 10, 2)->default(0);

    $table->decimal('balance', 10, 2)->default(0);

    $table->unsignedBigInteger('added_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_reports');
    }
};
