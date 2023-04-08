<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
			$table->string('gender')->nullable();
            $table->string('phone_no')->nullable();
			$table->string('location')->nullable();
			$table->string('city')->nullable();
			$table->string('postcode')->nullable();
			$table->string('latitude')->nullable();
			$table->string('longitude')->nullable();
			$table->integer('user_id')->nullable();
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
        Schema::dropIfExists('user_details');
    }
}
