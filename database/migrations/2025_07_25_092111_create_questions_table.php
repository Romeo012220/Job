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
     Schema::create('questions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('question_group_id');
    $table->text('question_text');
    $table->timestamps();

    $table->foreign('question_group_id')->references('id')->on('question_groups')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
