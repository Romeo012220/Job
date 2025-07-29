<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeSalaryNullableInJobsTable extends Migration
{
    public function up()
    {
    Schema::table('jobs', function (Blueprint $table) {
    $table->decimal('salary', 15, 2)->nullable()->change(); // 13 digits + 2 decimals
});

    }

    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->decimal('salary', 10, 2)->nullable(false)->change();
        });
    }
}

