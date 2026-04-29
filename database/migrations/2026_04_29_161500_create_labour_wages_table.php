<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('labour_wages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('labour_id');
            $table->decimal('daily_wage', 10, 2);
            $table->date('effective_from');
            $table->date('effective_to')->nullable();
            $table->timestamps();

            $table->foreign('labour_id')
                ->references('id')
                ->on('labours')
                ->onDelete('cascade');

            $table->unique(['labour_id', 'effective_from']);
            $table->index(['labour_id', 'effective_from', 'effective_to']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('labour_wages');
    }
};

