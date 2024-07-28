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
        Schema::create('finiancialreports', function (Blueprint $table) {
          $table->id();
          $table->bigInteger('charities_id')->unsigned()->nullable();
            $table->bigInteger('donation_id')->unsigned()->nullable();
          $table->date('date');
          $table->string('description');
          $table->timestamps();
            $table->foreign('charities_id')->references('id')->on('charities')->onDelete('cascade');
            $table->foreign('donation_id')->references('id')->on('donations')->onDelete('cascade');

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finiancialreports');
    }
};
