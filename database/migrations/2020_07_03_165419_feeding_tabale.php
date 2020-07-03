<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FeedingTabale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeding', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('type_id')->references('id')->on('types');
            $table->timestamps();
            $table->timestamps('feedtime');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('id')->references('id')->on('foodtype');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeding');
        //
    }
}
