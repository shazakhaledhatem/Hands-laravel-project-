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
        Schema::create('charities', function (Blueprint $table) {
          $table->id();
        $table->string('name');
        $table->string('description');
        $table->string('address');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->text('image')->nullable();
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
         $table->enum('status', ['accepting', 'waiting', 'rejecting'])->default('rejecting')->nullable();
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
        Schema::dropIfExists('charities');
    }
};
