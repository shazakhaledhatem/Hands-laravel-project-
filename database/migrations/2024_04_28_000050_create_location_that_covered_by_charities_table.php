<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_that_covered_by_charities', function (Blueprint $table) {
          $table->id();
         $table->string('governorate');
         $table->string('district');
         $table->string('sub_district');
         $table->string('community');
         $table->string('street');
         $table->unsignedBigInteger('charities_id');
         $table->timestamps();

         $table->foreign('charities_id')->references('id')->on('charities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_that_covered_by_charities');
    }
};
