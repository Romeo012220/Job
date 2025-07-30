<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
         //   $table->dropColumn('salary');
        });
    }

     public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
         //   $table->decimal('salary', 15, 2)->nullable(); // Re-add salary if rollback
        });
    }
};
