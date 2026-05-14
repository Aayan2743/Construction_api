<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_funds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->decimal('total_received', 12, 2)->default(0);
            $table->unsignedBigInteger('added_by');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['project_id', 'added_by']);
            $table->index(['project_id', 'added_by']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_funds');
    }
};

