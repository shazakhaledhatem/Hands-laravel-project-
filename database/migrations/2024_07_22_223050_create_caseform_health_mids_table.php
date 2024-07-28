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
        Schema::create('caseform_health_mids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caseforms_id');
            $table->unsignedBigInteger('caseformhealths_id');
            $table->unsignedBigInteger('assign_id')->nullable();
            $table->date('date')->nullable();

            $table->timestamps();

            $table->foreign('caseforms_id')->references('id')->on('caseforms')->onDelete('cascade');
            $table->foreign('caseformhealths_id')->references('id')->on('caseform_healths')->onDelete('cascade');
            $table->foreign('assign_id')->references('id')->on('assign_orders_volunteers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caseform_health_mids');
    }
};
