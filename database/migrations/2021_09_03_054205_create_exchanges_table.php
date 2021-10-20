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
            $table->foreignId('exchange_id')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('book_id');
            $table->foreignId('expected_book_id')->nullable();
            $table->boolean('accepted_offer_id')->nullable();
            $table->integer('book_edition')->default(1)->nullable();
            $table->enum('book_print', ['original', 'nilkhet', 'news'])->nullable();
            $table->integer('book_age')->nullable();
            $table->integer('markings_percentage')->nullable();
            $table->integer('markings_density')->nullable();
            $table->integer('missing_pages')->default(0)->nullable();
            $table->integer('book_worth');
            $table->text('description')->nullable();
            $table->string('pickup_location')->nullable();
            $table->timestamp('pickup_time')->nullable();
            $table->boolean('complete')->default(false);
            $table->timestamps();
            $table->unique(['exchange_id', 'user_id', 'book_id']);
        });

        Schema::create('ebook_exchanges', function (Blueprint $table){
            $table->id();
            $table->foreignId('ebook_exchange_id')->nullable();
            $table->foreignId('book_id');
            $table->foreignId('user_id');
            $table->foreignId('expected_book_id')->nullable();
            $table->boolean('accepted_offer_id')->nullable();
            $table->integer('book_edition')->default(1)->nullable();
            $table->string('ebook');
            $table->timestamps();
            $table->unique(['ebook_exchange_id', 'user_id', 'book_id']);
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
        Schema::dropIfExists('ebook_exchanges');
    }
}
