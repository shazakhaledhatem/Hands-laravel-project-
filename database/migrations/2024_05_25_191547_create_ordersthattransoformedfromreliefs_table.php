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
        Schema::create('orderstransoformedreliefs', function (Blueprint $table) {
          $table->bigIncrements('id');
      $table->bigInteger('charities_id')->unsigned()->nullable();
      $table->bigInteger('beneficiaries__reliefs_id')->unsigned();
      $table->text('reasonoftransformed');
      $table->timestamps();


          $table->foreign('beneficiaries__reliefs_id')->references('id')->on('beneficiary__reliefs')->onDelete('cascade');
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
        Schema::dropIfExists('ordersthattransoformedfromreliefs');
    }
};
