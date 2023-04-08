<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
			$table->integer('service_id')->default(0);
			$table->integer('customer_id')->default(0);
			$table->string('customer_name')->nullable();
			$table->string('email')->nullable();
			$table->string('phone_no')->nullable();
			$table->float('total_amount')->default(0);
			$table->date('order_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
