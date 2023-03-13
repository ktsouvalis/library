<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('writer',255);
            $table->string('title', 255);
            $table->string('publisher',255);
            $table->string('subject',255)->nullable();
            $table->string('publish_place',255)->nullable();
            $table->string('publish_year',255)->nullable();
            $table->integer('no_of_pages')->nullable();
            $table->string('acquired_by')->nullable();
            $table->date('acquired_date')->nullable();
            $table->text('comments')->nullable();
            $table->boolean('available');
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
    }
};
