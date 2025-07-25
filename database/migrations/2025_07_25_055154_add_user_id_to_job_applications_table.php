<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up()
{
    Schema::table('job_applications', function (Blueprint $table) {
        if (!Schema::hasColumn('job_applications', 'name')) {
            $table->string('name')->after('user_id');
        }
        if (!Schema::hasColumn('job_applications', 'email')) {
            $table->string('email')->after('name');
        }
        if (!Schema::hasColumn('job_applications', 'cover_letter')) {
            $table->text('cover_letter')->nullable()->after('email');
        }
        if (!Schema::hasColumn('job_applications', 'resume_path')) {
            $table->string('resume_path')->nullable()->after('cover_letter');
        }
    });
}

public function down()
{
    Schema::table('job_applications', function (Blueprint $table) {
        $table->dropColumn(['name', 'email', 'cover_letter', 'resume_path']);
    });
}

};
