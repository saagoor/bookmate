<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWritersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('writers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('location')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::create('books_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id');
            $table->foreignId('writer_id');
            $table->boolean('translator')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('writers');
        Schema::dropIfExists('book_authors');
    }
}
