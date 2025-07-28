<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_job_answers_table.php
public function up()
{
    Schema::create('job_answers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('job_application_id')->constrained()->onDelete('cascade');
        $table->foreignId('job_question_id')->constrained()->onDelete('cascade');
        $table->text('answer');
        $table->timestamps();
    });
}









    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_answers');
    }
};
