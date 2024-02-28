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
        Schema::create('submission_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('submission_id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('weight_id');
            $table->timestamps();

            $table->foreign('submission_id')->on('submissions')->references('id')->cascadeOnDelete();
            $table->foreign('question_id')->on('questions')->references('id')->cascadeOnDelete();
            $table->foreign('weight_id')->on('weights')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_items');
    }
};
