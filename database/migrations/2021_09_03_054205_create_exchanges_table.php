<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('book_id');
            $table->integer('book_worth');
            $table->foreignId('expected_book_id')->nullable();
            $table->boolean('accepted_offer_id')->nullable();
            $table->enum('book_condition', ['average', 'good', 'fresh', 'full_fresh']);
            $table->string('book_edition')->nullable();
            $table->text('description')->nullable();
            $table->string('pickup_location')->nullable();
            $table->timestamps();
        });

        Schema::create('exchange_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exchange_id');
            $table->foreignId('user_id');
            $table->foreignId('offered_book_id');
            $table->integer('book_worth');
            $table->enum('book_condition', ['average', 'good', 'fresh', 'full_fresh']);
            $table->string('book_edition')->nullable();
            $table->timestamps();

            $table->unique(['exchange_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchanges');
        Schema::dropIfExists('exchange_requests');
    }
}
