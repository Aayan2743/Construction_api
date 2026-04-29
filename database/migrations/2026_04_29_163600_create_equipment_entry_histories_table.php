<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_entry_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_entry_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('remarks', 500);
            $table->json('changes')->nullable();
            $table->timestamps();

            $table->foreign('equipment_entry_id')
                ->references('id')
                ->on('equipment_entries')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->index(['equipment_entry_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_entry_histories');
    }
};

