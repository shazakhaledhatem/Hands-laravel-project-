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
        Schema::create('effectivenesses', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->text('image')->nullable();
          $table->text('type_of_effectiveness');
          $table->integer('initial_budget');
          $table->integer('final_budget')->nullable();
          $table->integer('numberofvolunteer');
          $table->integer('numberofparicipations')->default(0);
          $table->date('start_date');
          $table->date('end_date');
          $table->text('description');
          $table->unsignedBigInteger('location_that_covered_by_charities_id');
          $table->unsignedBigInteger('charities_id');
          $table->timestamps();
          $table->foreign('location_that_covered_by_charities_id')->references('id')->on('location_that_covered_by_charities');
          $table->foreign('charities_id')->references('id')->on('charities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('effectivenesses');
    }
};
