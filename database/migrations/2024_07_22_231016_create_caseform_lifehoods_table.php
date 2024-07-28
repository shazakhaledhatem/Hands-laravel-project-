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
        Schema::create('caseform_lifehoods', function (Blueprint $table) {
            $table->id();
            $table->text('profession_learn')->nullable();
            $table->text('reason_profession')->nullable();
            $table->boolean('finanical_scholar_support')->default(false)->nullable();
            $table->text('major')->nullable();
            $table->text('year_in_work')->nullable();
            $table->text('knowlodege_you_earn')->nullable();
            $table->text('your_previous_work')->nullable();
            $table->boolean('looking_for_job')->default(false)->nullable();
            $table->text('type_looking_for_job')->nullable();
            $table->boolean('apply_job')->default(false)->nullable();
            $table->text('number_request')->nullable();
              $table->boolean('job_offer')->default(false)->nullable();
              $table->text('what_kind')->nullable();
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
        Schema::dropIfExists('caseform_lifehoods');
    }
};
