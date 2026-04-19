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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
           $table->unsignedBigInteger('labour_id');
        $table->date('date'); // today's date
        $table->boolean('is_present')->default(1);
        $table->unsignedBigInteger('added_by');
        $table->timestamps();

        $table->foreign('labour_id')->references('id')->on('labours')->onDelete('cascade');
        $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');

        // 🔥 prevent duplicate attendance per day
        $table->unique(['labour_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
