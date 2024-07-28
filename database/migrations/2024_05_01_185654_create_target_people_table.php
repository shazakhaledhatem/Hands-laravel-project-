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
        Schema::create('target_people', function (Blueprint $table) {
            $table->id();
            $table->integer('age')->nullable();
            $table->boolean('babies')->default(false)->nullable();
            $table->boolean('female')->default(false)->nullable();
            $table->boolean('male')->default(false)->nullable();
            $table->boolean('elderly')->default(false)->nullable();
            $table->boolean('youth')->default(false)->nullable();
           $table->boolean('childern')->default(false)->nullable();
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
        Schema::dropIfExists('target_people');
    }
};
