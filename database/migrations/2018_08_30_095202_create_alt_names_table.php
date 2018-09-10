<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAltNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alt_names', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profile_id');
            $table->string('name');
            // $table->string('locale',10);
            $table->string('description')->nullable();
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
        Schema::dropIfExists('alt_names');
    }
}
