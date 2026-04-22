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
        Schema::create('account_allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // manager/accountant/supervisor
            $table->string('role');
            $table->unsignedBigInteger('project_id');
            $table->decimal('amount', 10, 2);

            $table->timestamps();

            // 🔗 Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_allocations');
    }
};