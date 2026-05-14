<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('labour_id')->nullable();
            $table->string('type', 20); // labour/material/machinery
            $table->string('sector', 255)->nullable(); // UI-only for now (no sectors table yet)
            $table->decimal('amount', 12, 2);
            $table->text('description')->nullable();
            $table->date('expense_date')->nullable();
            $table->unsignedBigInteger('added_by');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('labour_id')->references('id')->on('labours')->onDelete('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');

            $table->index(['project_id', 'vendor_id', 'labour_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};

