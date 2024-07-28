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
        Schema::create('charity11s', function (Blueprint $table) {
          $table->id();
        $table->string('name');
        $table->string('address');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->text('image');
        $table->string('nameoftheheadofcharity');
        $table->string('vicepresidentofcharity');
        $table->string('typeofcharity');
        $table->string('nameofcashier');
        $table->text('linkwebsite');
        $table->bigInteger('numberbankaccount')->unique();
        $table->bigInteger('licensenumber')->unique();
        $table->integer('numberofvolunteer');
        $table->text('charityphone');
        $table->text('whatsappnumber');
        $table->text('linkoffacebookpage');
        $table->string('remember_token', 100)->nullable();
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
        Schema::dropIfExists('charity11s');
    }
};
