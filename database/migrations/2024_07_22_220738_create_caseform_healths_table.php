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
        Schema::create('caseform_healths', function (Blueprint $table) {
            $table->id();
            $table->boolean('insourance')->default(false)->nullable();
            $table->text('type_ins')->nullable();
            $table->text('main_pro')->nullable();
            $table->text('suffer_time')->nullable();
            $table->boolean('inh_history')->default(false)->nullable();
            $table->text('inh_history_name')->nullable();
            $table->boolean('surgery')->default(false)->nullable();
            $table->text('surgery_name')->nullable();
            $table->text('symptom')->nullable();
            $table->text('symptom_time')->nullable();
            $table->text('time_cond')->nullable();
            $table->text('daily_effect')->nullable();
            $table->boolean('pirman_medicine')->default(false)->nullable();
            $table->text('priman_name')->nullable();
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
        Schema::dropIfExists('caseform_healths');
    }
};
