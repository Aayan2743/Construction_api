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
        Schema::create('labour_works', function (Blueprint $table) {
            $table->id();

            $table->foreignId('labour_id')->constrained('labours')->onDelete('cascade');

            $table->date('date');

            $table->text('work_done')->nullable();

            $table->string('measurement')->nullable();

            $table->unsignedBigInteger('added_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labour_works');
    }
};
