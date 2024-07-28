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
        Schema::create('caseform_education_mids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caseforms_id');
            $table->unsignedBigInteger('caseformeducations_id');
            $table->unsignedBigInteger('assign_id')->nullable();
            $table->date('date')->nullable();

            $table->timestamps();

            $table->foreign('caseforms_id')->references('id')->on('caseforms')->onDelete('cascade');
            $table->foreign('caseformeducations_id')->references('id')->on('caseform_educations')->onDelete('cascade');
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
        Schema::dropIfExists('caseform_education_mids');
    }
};
