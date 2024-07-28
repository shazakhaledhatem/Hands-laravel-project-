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
        Schema::create('beneficiaries', function (Blueprint $table) {
          $table->id();
          $table->text('first_name');
          $table->text('last_name');
          $table->date('birth_date');
          $table->text('address');

              $table->boolean('malebreadwinnerforthefamily')->default(false);
              $table->boolean('femalebreadwinnerforthefamily')->default(false);
              $table->boolean('Youthwithoutfamily')->default(false);
              $table->boolean('girlwithoutfamily')->default(false);
              $table->boolean('orphans')->default(false);
              $table->boolean('injured')->default(false);
              $table->unsignedBigInteger('users_id');
              $table->boolean('displacedpeople')->default(false);
              $table->integer('totalnumberofchildern');
              $table->integer('numberofdiablechildern');
              $table->text('phone');
              $table->text('Discription');
              $table->timestamps();

              $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiaries');
    }
};
