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
        Schema::create('labour_work_edit_histories', function (Blueprint $table) {
             $table->id();

    $table->foreignId('labour_work_id')
        ->constrained('labour_works')
        ->onDelete('cascade');

    $table->text('reason');

    $table->text('old_work_done')->nullable();

    $table->string('old_measurement')->nullable();

    $table->date('old_date')->nullable();

    $table->unsignedBigInteger('edited_by')->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labour_work_edit_histories');
    }
};
