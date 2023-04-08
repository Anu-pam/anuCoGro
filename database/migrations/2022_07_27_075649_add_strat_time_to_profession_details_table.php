<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStratTimeToProfessionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profession_details', function (Blueprint $table) {
            $table->string('start_time')->after('message')->nullable();
            $table->string('stop_time')->after('start_time')->nullable();
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
