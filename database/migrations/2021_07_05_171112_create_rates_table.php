<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id("rate_id");
            $table->unsignedBigInteger('hotel_id')->unsigned();
            $table->date("from_date");
            $table->date("to_date");
            $table->float("rate_for_adult");
            $table->float("rate_for_child");
            $table->foreign("hotel_id")->references("hotel_id")->on("hotels");
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
