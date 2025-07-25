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
        // database/migrations/xxxx_xx_xx_create_job_questions_table.php
Schema::create('job_questions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('job_id');
    $table->text('question');
    $table->timestamps();

    $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_questions');
    }
};
