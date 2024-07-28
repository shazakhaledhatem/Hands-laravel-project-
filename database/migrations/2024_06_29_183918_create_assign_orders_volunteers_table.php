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
        Schema::create('assign_orders_volunteers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beneficiaries_id');
            $table->unsignedBigInteger('charities_id')->nullable();
            $table->unsignedBigInteger('volunteers_id');
            $table->text('discription')->nullable();
            $table->timestamps();

            $table->foreign('beneficiaries_id')->references('id')->on('beneficiaries')->onDelete('cascade');
            $table->foreign('charities_id')->references('id')->on('charities')->onDelete('cascade');
            $table->foreign('volunteers_id')->references('id')->on('volunteers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assign_orders_volunteers');
    }
};
