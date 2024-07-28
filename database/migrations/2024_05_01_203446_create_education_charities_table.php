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
        Schema::create('education_charities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('charities_id')->nullable();
            $table->unsignedBigInteger('education_id')->nullable();

          //  $table->text('description');
            $table->timestamps();

            $table->foreign('education_id')->references('id')->on('education')->onDelete('cascade');
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
        Schema::dropIfExists('education_charities');
    }
};
