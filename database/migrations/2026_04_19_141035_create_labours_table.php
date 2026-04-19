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
        Schema::create('labours', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->integer('age');
            $table->enum('gender', ['male', 'female', 'other']);
          $table->unsignedBigInteger('vendor_id'); // ✅ changed
            $table->string('phone', 15);
            $table->unsignedBigInteger('added_by'); // user id
            $table->timestamps();

            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
              $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labours');
    }
};
