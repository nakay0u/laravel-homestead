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
        Schema::create('hash_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps();
        });

        Schema::create('hash_tag_tweet', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hash_tag_id');
            $table->unsignedBigInteger('tweet_id');
            $table->timestamps();

            $table->foreign('tweet_id')->references('id')->on('tweets');
            $table->foreign('hash_tag_id')->references('id')->on('hash_tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hash_tags');
        Schema::dropIfExists('hash_tag_tweet');
    }
};
