<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('path');
            $table->integer('size');
            $table->string('mime_type')->nullable();
            $table->string('caption')->nullable();
            $table->string('used_as');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        DB::statement('ALTER TABLE attachments ADD FULLTEXT INDEX fulltext_index(caption)');

        Schema::create('attachmentables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('attachment_id')->unsigned();
            $table->bigInteger('attachmentable_id')->unsigned();
            $table->string('attachmentable_type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('attachment_id')->references('id')->on('attachments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('attachmentables');
    }
}
