<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_entry_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_entry_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('remarks', 500);
            $table->json('changes')->nullable();
            $table->timestamps();

            $table->foreign('material_entry_id')
                ->references('id')
                ->on('material_entries')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->index(['material_entry_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_entry_histories');
    }
};

