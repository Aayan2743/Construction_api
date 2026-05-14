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
        Schema::create('project_expenses', function (Blueprint $table) {
            $table->id();
              $table->unsignedBigInteger('project_id');

    $table->enum('expense_type', [

        'labour',
        'material',
        'machine'

    ]);

    // ✅ Vendor / Labour Party / Machine Party
    $table->unsignedBigInteger('party_id')->nullable();

    $table->decimal('amount', 12, 2);

    $table->text('remarks')->nullable();

    $table->date('date');

    $table->unsignedBigInteger('added_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_expenses');
    }
};
