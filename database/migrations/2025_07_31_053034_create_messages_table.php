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
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('application_id');
        $table->text('message');
        $table->timestamps();

        $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');

            //user reply to a message
        $table->string('sender_type')->default('admin'); // or 'user'

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
