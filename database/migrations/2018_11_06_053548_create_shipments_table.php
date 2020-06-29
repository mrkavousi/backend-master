<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->integer('vehicle_id')->unsigned();
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
        });

        Schema::create('shipment_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipment_id')->unsigned();
            $table->integer('package_model_id')->unsigned();
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('shipment_id')->references('id')->on('shipments');
            $table->foreign('package_model_id')->references('id')->on('package_model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('shipment_packages');
    }
}
