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
    Schema::table('messages', function (Blueprint $table) {
        $table->string('sender_type')->default('user'); // Or nullable if preferred
    });
}

public function down()
{
    Schema::table('messages', function (Blueprint $table) {
        $table->dropColumn('sender_type');
    });
}

};
