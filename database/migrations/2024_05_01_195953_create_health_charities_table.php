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
        Schema::create('health_charities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('charities_id')->nullable();
            $table->unsignedBigInteger('healths_id')->nullable();

          //  $table->text('description');
            $table->timestamps();

            $table->foreign('healths_id')->references('id')->on('healths')->onDelete('cascade');
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
        Schema::dropIfExists('health_charities');
    }
};
