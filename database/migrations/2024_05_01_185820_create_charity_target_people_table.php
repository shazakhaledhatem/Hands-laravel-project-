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
        Schema::create('charity_target_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('charities_id')->nullable();
            $table->unsignedBigInteger('target_people_id')->nullable();
            $table->text('vision_of_charity');
            $table->text('charity_goals');
            $table->text('charity_message');
            $table->timestamps();

            $table->foreign('target_people_id')->references('id')->on('target_people')->onDelete('cascade');
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
        Schema::dropIfExists('charity_target_people');
    }
};
