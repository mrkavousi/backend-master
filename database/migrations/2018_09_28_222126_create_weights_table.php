<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weights', function (Blueprint $table) {
            $table->increments('id');
            $table->string('weightable_type');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('gross_weight');
            $table->integer('net_weight');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE weights ADD FULLTEXT INDEX fulltext_index(name, description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weights');
        Schema::dropIfExists('weight_model');
    }
}
