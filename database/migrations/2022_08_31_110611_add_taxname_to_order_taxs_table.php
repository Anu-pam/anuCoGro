<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxnameToOrderTaxsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_taxs', function (Blueprint $table) {
            $table->string('value')->after('tax_id');
            $table->string('type')->after('value');
            $table->string('taxName')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_taxs', function (Blueprint $table) {
            //
        });
    }
}
