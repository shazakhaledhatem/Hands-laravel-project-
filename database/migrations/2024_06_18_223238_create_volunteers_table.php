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
        Schema::create('volunteers', function (Blueprint $table) {
          $table->id();
        $table->string('full_name');
        $table->string('mother_name');
        $table->string('birth_place');
        $table->date('birth_date');
        $table->text('national_number');
        $table->enum('gender', ['male', 'female']);
        $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
        $table->text('phone_number');
        $table->string('address');
        $table->string('nationality');
        $table->string('mandatory_service');
        $table->string('email');
        $table->string('facebook');
        $table->string('instagram');
        $table->string('whatsapp');
        $table->text('education');
        $table->text('specilization')->nullable();
        $table->integer('number_of_years')->nullable();
        $table->text('education_rate')->nullable();
        $table->text('language_proficiency')->nullable();
        $table->text('work_experiences')->nullable();
        $table->text('training_courses')->nullable();
        $table->text('other_volunteering')->nullable();
        $table->text('hobbies')->nullable();
        $table->text('ambition')->nullable();
        $table->text('strengths')->nullable();
        $table->text('weaknesses')->nullable();
        $table->text('motivation_for_volunteering')->nullable();
        $table->text('why_charity');
        $table->string('availability_for_volunteering');
        $table->string('preferred_time');
        $table->boolean('previous_experience')->default(false)->nullable();
        $table->boolean('Developmental')->default(false)->nullable();
        $table->boolean('Child_care')->default(false)->nullable();
        $table->boolean('Training')->default(false)->nullable();
        $table->boolean('Shelter_and_relief')->default(false)->nullable();
        $table->boolean('Events_and_conferences')->default(false)->nullable();
        $table->boolean('Awareness_campaigns')->default(false)->nullable();
        $table->boolean('Elderly_care')->default(false)->nullable();
        $table->boolean('Supporting_women')->default(false)->nullable();
        $table->boolean('Maintenance_technician')->default(false)->nullable();
        $table->boolean('field_media_photography')->default(false)->nullable();
        $table->boolean('Administrative_field')->default(false)->nullable();
        $table->unsignedBigInteger('charities_id');
              $table->unsignedBigInteger('users_id');
        $table->enum('status', ['waiting', 'accept','reject']);
        $table->timestamps();

        $table->foreign('charities_id')->references('id')->on('charities');
        $table->foreign('users_id')->references('id')->on('users');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteers');
    }
};
