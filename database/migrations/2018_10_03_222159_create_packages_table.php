<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('size_id')->unsigned();
            $table->integer('weight_id')->unsigned();
            $table->integer('grade_id')->unsigned()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('size_id')->references('id')->on('sizes');
            $table->foreign('weight_id')->references('id')->on('weights');
            $table->foreign('grade_id')->references('id')->on('grades');
        });

        DB::statement('ALTER TABLE packages ADD FULLTEXT INDEX fulltext_index(name, description)');

        Schema::create('package_model', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('package_id')->unsigned();
            $table->integer('packageable_id')->unsigned();
            $table->string('packageable_type');
            $table->integer('quantity');
            $table->integer('ordered_quantity')->default(0);
            $table->integer('floor')->nullable();
            $table->integer('unload_id')->unsigned()->nullable();
            $table->integer('storage_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('unload_id')->references('id')->on('processes');
            $table->foreign('storage_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
        Schema::dropIfExists('package_model');
    }
}
