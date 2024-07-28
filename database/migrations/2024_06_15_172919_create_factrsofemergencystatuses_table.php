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
        Schema::create('factrsofemergencystatuses', function (Blueprint $table) {
          $table->id();
        $table->string('type');
        $table->unsignedBigInteger('emergencystatus_id');
        $table->foreign('emergencystatus_id')->references('id')->on('emeregency_statuses')->onDelete('cascade');
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
        Schema::dropIfExists('factrsofemergencystatuses');
    }
};
