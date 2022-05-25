<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->text("description")->nullable();
            $table->double("price");
            $table->integer("showPrice")->default(1);
            $table->integer("roomsNumber")->nullable();
            $table->integer("bathroomsNumber")->nullable();
            $table->integer("parkingNumber")->nullable();
            $table->integer("bedroomsNumber")->nullable();
            $table->integer("accepted")->default(0);
            $table->foreignId('userId')->constrained('users');
            $table->bigInteger('categoryId');
            $table->bigInteger('typeId');
            $table->integer('sold')->default(0);
            $table->bigInteger('packageId')->nullable();
            $table->string("locationDescription")->nullable();
            $table->bigInteger('countryId')->nullable();
            $table->bigInteger('stateId')->nullable();
            $table->bigInteger('cityId')->nullable();
            $table->string("contactInfo")->nullable();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
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
        Schema::dropIfExists('properties');
    }
}
