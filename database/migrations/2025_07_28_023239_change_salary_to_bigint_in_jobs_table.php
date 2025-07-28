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
        Schema::table('jobs', function (Blueprint $table) {
            $table->unsignedBigInteger('salary')->change(); // Allow big salaries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->integer('salary')->change(); // Revert if needed
        });
    }
};
