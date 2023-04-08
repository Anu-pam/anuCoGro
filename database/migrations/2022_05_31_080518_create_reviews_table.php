<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
			$table->integer('service_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->string('user_name')->nullable();
			$table->string('user_email_id')->nullable();
			$table->string('user_mobile_no')->nullable();
			$table->float('rating')->default(0);
			$table->text('review_text')->nullable();
			$table->dateTime('review_time')->nullable();
			$table->integer('status')->default(0);
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
        Schema::dropIfExists('reviews');
    }
}
