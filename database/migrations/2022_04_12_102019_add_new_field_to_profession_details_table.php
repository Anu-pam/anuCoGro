<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldToProfessionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profession_details', function (Blueprint $table) {
             $table->string('business')->nullable()->after('udid');
			 $table->string('city')->nullable()->after('location');
			 $table->string('postcode')->nullable()->after('city');
			 $table->string('message')->nullable()->after('postcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profession_details', function (Blueprint $table) {
            //
        });
    }
}
