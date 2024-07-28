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
        Schema::create('join_effectivenesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('charities_id')->nullable();
            $table->unsignedBigInteger('volenteer_id')->nullable();
  $table->unsignedBigInteger('effectiveness_id')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->nullable();


            $table->foreign('charities_id')->references('id')->on('charities')->onDelete('cascade');
            $table->foreign('volenteer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('effectiveness_id')->references('id')->on('effectivenesses')->onDelete('cascade');
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
        Schema::dropIfExists('join_effectivenesses');
    }
};
