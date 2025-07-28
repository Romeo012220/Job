<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('job_questions', function (Blueprint $table) {
        $table->unsignedBigInteger('group_id')->nullable()->after('job_id');
        $table->foreign('group_id')->references('id')->on('question_groups')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_questions', function (Blueprint $table) {
            //
        });
    }
};
