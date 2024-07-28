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
        Schema::create('caseforms', function (Blueprint $table) {
            $table->id();
            $table->boolean('main_res')->default(false)->nullable();
            $table->text('main_res_des')->nullable();
            $table->boolean('add_res')->default(false)->nullable();
            $table->text('add_res_des')->nullable();
            $table->boolean('diff_cover_monthly_exp')->default(false)->nullable();
            $table->boolean('loans')->default(false)->nullable();
            $table->text('value_loans')->nullable();
            $table->text('rent_own')->nullable();
            $table->text('type_of_res')->nullable();
            $table->text('rent_value')->nullable();
              $table->text('desc')->nullable();

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
        Schema::dropIfExists('caseforms');
    }
};
