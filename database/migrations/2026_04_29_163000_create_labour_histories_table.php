<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('labour_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('labour_id');
            $table->unsignedBigInteger('user_id')->nullable(); // who updated (manager)
            $table->string('type', 50)->default('update'); // update | wage
            $table->string('remarks', 500);
            $table->json('changes')->nullable(); // what changed
            $table->timestamps();

            $table->foreign('labour_id')
                ->references('id')
                ->on('labours')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->index(['labour_id', 'type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('labour_histories');
    }
};

