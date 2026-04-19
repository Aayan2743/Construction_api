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
        Schema::create('labour_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id'); // 🔥 instead of party_name
        $table->integer('mason')->default(0);
        $table->integer('male_skilled')->default(0);
        $table->integer('female_unskilled')->default(0);
        $table->integer('others')->default(0);
        $table->text('work_done')->nullable();
        $table->date('date');
        $table->unsignedBigInteger('added_by');
        $table->timestamps();

        $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');

        // 🔥 prevent duplicate report per day
        $table->unique(['vendor_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labour_reports');
    }
};
