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
        Schema::create('reliefs', function (Blueprint $table) {
          $table->id();
         $table->boolean('home')->default(false)->nullable();
         $table->boolean('housefurniture')->default(false)->nullable();
         $table->boolean('food')->default(false)->nullable();
         $table->boolean('clothes')->default(false)->nullable();
         $table->boolean('money')->default(false)->nullable();
         $table->boolean('psychologicalaid')->default(false)->nullable();
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
        Schema::dropIfExists('reliefs');
    }
};
