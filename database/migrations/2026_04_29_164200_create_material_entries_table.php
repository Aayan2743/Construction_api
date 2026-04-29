<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->decimal('qty', 10, 2)->default(0);
            $table->unsignedBigInteger('project_id');
            $table->string('supplier', 255)->nullable();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('added_by');
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');

            $table->index(['project_id', 'vendor_id', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_entries');
    }
};

