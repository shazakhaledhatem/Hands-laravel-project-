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
        Schema::create('caseform_educations', function (Blueprint $table) {
            $table->id();
            $table->text('class')->nullable();
            $table->text('school_name')->nullable();
            $table->text('number_of_year_delay')->nullable();
            $table->text('reason_of_delay')->nullable();
            $table->text('times_to_buy_clothes_during_year')->nullable();
            $table->text('cost_of_tools_in_semester')->nullable();
            $table->boolean('participate_in_courses')->default(false)->nullable();
            $table->text('participate_in_courses_name')->nullable();
            $table->boolean('need_courses')->default(false)->nullable();
            $table->text('courses_name')->nullable();
            $table->text('many_times_change_bages')->nullable();
            $table->text('any_hopies')->nullable();
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
        Schema::dropIfExists('caseform_educations');
    }
};
