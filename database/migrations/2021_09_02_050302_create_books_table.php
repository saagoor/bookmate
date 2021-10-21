<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('language')->default('english');
            $table->string('category')->nullable();
            $table->string('isbn')->nullable();
            $table->string('cover')->nullable();
            $table->date('published_at')->nullable();
            $table->foreignId('publisher_id')->nullable();
            $table->integer('page_count')->nullable();
            $table->text('summary')->nullable();
            $table->timestamps();
        });

        Schema::create('books_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')
                ->references('id')
                ->on('books')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['book_id', 'user_id']);
        });

        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->references('id')->on('books')->cascadeOnDelete();
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
        Schema::dropIfExists('books');
        Schema::dropIfExists('books_reads');
        Schema::dropIfExists('views');
    }
}
