<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommercialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercials', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->double('price')->nullable();
            $table->integer('showPrice')->nullable();
            $table->double('floor')->nullable();
            $table->string('type')->nullable();
            $table->integer('category')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('accepted')->nullable();
            $table->integer('sold')->default(0);
            $table->text('location')->nullable();
            $table->double('lang')->nullable();
            $table->double('lan')->nullable();
            $table->text('extra1')->nullable();//contact info
            $table->text('extra2')->nullable();
            $table->integer('extra3')->nullable();
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
        Schema::dropIfExists('commercials');
    }
}
