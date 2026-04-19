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
        Schema::create('equipment_entries', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('equipment_id'); // item_id
        $table->unsignedBigInteger('vendor_id');

        $table->time('start_time');
        $table->time('end_time');
        $table->decimal('total_hours', 5, 2)->default(0);

        $table->text('work_done')->nullable();

        $table->date('date');
        $table->unsignedBigInteger('added_by');

        $table->timestamps();

        $table->foreign('equipment_id')->references('id')->on('items')->onDelete('cascade');
        $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_entries');
    }
};
