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
        Schema::create('caseform_reliefs', function (Blueprint $table) {
            $table->id();
            $table->boolean('damage_from_disaster')->default(false)->nullable();
            $table->boolean('furniture_essitional')->default(false)->nullable();
            $table->boolean('clothes_for_all_season')->default(false)->nullable();
            $table->boolean('clothes_for_work_school')->default(false)->nullable();
            $table->boolean('enough_amount_of_food_daily')->default(false)->nullable();
            $table->boolean('help_from_organization')->default(false)->nullable();
            $table->boolean('suffer_psycologic_problem')->default(false)->nullable();
            $table->boolean('problem_food_plenty_family')->default(false)->nullable();
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
        Schema::dropIfExists('caseform_reliefs');
    }
};
