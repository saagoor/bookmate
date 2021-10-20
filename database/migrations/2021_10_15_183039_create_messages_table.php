<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table){
            $table->id();
            $table->foreignId('user_one_id');
            $table->foreignId('user_two_id');
            $table->timestamps();

            $table->unique(['user_one_id', 'user_two_id']);
            $table->unique(['user_two_id', 'user_one_id']);
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->references('id')->on('conversations')->cascadeOnDelete();
            $table->foreignId('sender_id');
            $table->foreignId('receiver_id');
            $table->text('message');
            $table->timestamp('seen_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
