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
            // Only add the foreign key if the column doesn't already exist
            if (!Schema::hasColumn('job_questions', 'group_id')) {
                $table->unsignedBigInteger('group_id')->nullable()->after('job_id');
                $table->foreign('group_id')->references('id')->on('question_groups')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_questions', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });
    }
};
