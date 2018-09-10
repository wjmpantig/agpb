<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('profile_id');
            $table->string('type');
            $table->string('filename');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('video')->nullable();
            $table->string('url');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('profile_id')->references('id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
