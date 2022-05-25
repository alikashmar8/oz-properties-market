<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->nullable();
            $table->bigInteger('propertyId')->nullable();
            $table->bigInteger('commercialId')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_role')->nullable();
            $table->string('user_phoneNumber')->nullable();
            $table->string('user_phoneNumberCode')->nullable();
            $table->string('user_bio')->nullable();
            $table->text("post_description")->nullable();
            $table->double("post_price")->nullable();
            $table->integer("post_roomsNumber")->nullable();
            $table->integer("post_bathroomsNumber")->nullable();
            $table->integer("post_parkingNumber")->nullable();
            $table->integer("post_bedroomsNumber")->nullable();
            $table->integer('commercial_floor')->nullable();
            $table->integer("post_accepted")->nullable();
            $table->foreignId('post_userId')->nullable();
            $table->string('post_category')->nullable();
            $table->string('post_type')->nullable();
            $table->string("post_locationDescription")->nullable();
            $table->string("post_contactInfo")->nullable();
            $table->double('post_longitude')->nullable();
            $table->double('post_latitude')->nullable();
            $table->integer('isCreated')->nullable();
            $table->integer('isUpdated')->nullable();
            $table->integer('isDeleted')->nullable();
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
        Schema::dropIfExists('histories');
    }
}
