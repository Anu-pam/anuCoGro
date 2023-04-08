<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->default(0);
            $table->string('name');
            $table->integer('status')->default(0);
            $table->float('min_price')->default(0);
            $table->float('max_price')->default(0);
            $table->integer('show_on_header')->default(0);
            $table->integer('service_type')->default(1)->comment('0=>from others,1=>from added services');
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
        Schema::dropIfExists('services');
    }
}
