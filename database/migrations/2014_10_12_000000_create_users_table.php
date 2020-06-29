<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->string('email_verification_code')->nullable();
            $table->string('mobile_verification_code')->nullable();
            $table->string('password');
            $table->integer('status')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE users ADD FULLTEXT INDEX fulltext_index(email, mobile)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
