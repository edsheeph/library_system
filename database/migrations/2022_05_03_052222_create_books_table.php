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
            $table->string("book_accession_no")->nullable();
            $table->string("book_title")->nullable();
            $table->longText("book_description")->nullable();
            $table->string("book_author")->nullable();
            $table->date("book_date_publish")->nullable();
            $table->string("book_publisher")->nullable();
            $table->unsignedBigInteger("book_category_id")->nullable();
            $table->string("book_dewey_decimal")->nullable();
            $table->unsignedBigInteger("book_type_id")->nullable();
            $table->timestamps();

            $table->foreign('book_category_id')->references('id')->on('book_categories');
            $table->foreign('book_type_id')->references('id')->on('book_types');
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
    }
}
