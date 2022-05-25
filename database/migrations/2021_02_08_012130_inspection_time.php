<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InspectionTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_time', function (Blueprint $table) {
            $table->id();
            $table->integer('propertyId');
            $table->date('date');
            $table->time('startTime');
            $table->time('endTime');
            $table->text('extra1')->nullable();
            $table->integer('extra2')->nullable();
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
        Schema::dropIfExists('inspection_time');
    }
}
