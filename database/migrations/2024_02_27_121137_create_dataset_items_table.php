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
        Schema::create('dataset_items', function (Blueprint $table) {
            $table->id();
            $table->integer('weight');
            $table->unsignedInteger('dataset_id');
            $table->unsignedInteger('question_id');
            $table->timestamps();

            $table->foreign('question_id')->on('questions')->references('id')->cascadeOnDelete();
            $table->foreign('dataset_id')->on('datasets')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_items');
    }
};
