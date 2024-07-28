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
        Schema::create('case_forms', function (Blueprint $table) {
      $table->id();
       $table->unsignedBigInteger('beneficiaries_id');

       //////////////////////معلومات تعريفية اولية بالقائم على دراسة الحالة
       $table->unsignedBigInteger('volunteer_id');
       $table->date('completion_date');
       $table->string('person_filled_form');
      $table->text('volunteer_phone');
       $table->unsignedBigInteger('charities_id');
////////////////////////////////معلومات تعريفية اولية بالحالة
$table->string('gender');
        $table->string('name_guardian_family_relationship')->nullable();
       $table->string('type_of_disability')->nullable();
       $table->text('father_phone')->nullable();
       $table->text('mother_phone')->nullable();
       $table->string('the_resident')->nullable();
       $table->text('land_phone')->nullable();
//////////////////////////////معلومات تعريفية بالوالدين

      $table->string('father_name')->nullable();
      $table->date('father_birthdate')->nullable();
      $table->integer('father_age')->nullable();
      $table->string('father_education')->nullable();
      $table->string('father_job')->nullable();

      $table->string('mother_name')->nullable();
      $table->date('mother_birthdate')->nullable();
      $table->integer('mother_age')->nullable();
      $table->string('mother_education')->nullable();
      $table->string('mother_job')->nullable();

      $table->string('kinship_mother_father')->nullable();
      $table->string('with_whom_case')->nullable();
///////////////////////////////معلومات عن الاخوة
      $table->integer('number_sibling')->nullable();
      $table->integer('number_female_brothers')->nullable();
      $table->integer('number_male_brothers')->nullable();
/////////////////////من يقيم مع الحالة
      $table->string('resident_name')->nullable();
      $table->string('resident_gender')->nullable();
      $table->date('resident_birthdate')->nullable();
      $table->integer('resident_age')->nullable();
      $table->string('resident_healthstatus')->nullable();
      $table->string('resident_education')->nullable();
      $table->string('resident_job')->nullable();


      $table->boolean('relatives_have_problems')->default(false)->nullable();
      $table->integer('relative_numbers_have_problems')->nullable()->nullable();

/////////////////////////////////////////////التاريخ الصحيي للام
      $table->integer('mother_pragnent_age')->nullable();
      $table->integer('pragnent_period')->nullable();
      $table->enum('pragnent_type', ['normal', 'unnormal'])->nullable();
     $table->string('complications_during_pregnancy')->nullable();
     $table->string('medications_during_pregnancy')->nullable();

       $table->string('postpartum_health_issues_birth')->nullable();
      // $table->string('postpartum_health_issues')->nullable();
       ////////////////////////// هل عانى الطفا من الاصابات التالية
       $table->boolean('surgery')->default(false)->nullable();
       $table->boolean('epileptic_seizures')->default(false)->nullable();
       $table->boolean('head_injury')->default(false)->nullable();
       $table->boolean('infantile_paralysis')->default(false)->nullable();
       $table->boolean('metabolic_disorder')->default(false)->nullable();

/////////////////////حساسية نت الطعام وما هي الانواع
         $table->string('allergy_to_some_foods')->nullable();

///////////////////////////////الوضع الصحي الحالي للحالة
     $table->boolean('hearing_problems')->default(false)->nullable();
   $table->boolean('optical_problems')->default(false)->nullable();
     $table->boolean('speech_problems')->default(false)->nullable();
       $table->boolean('epileptic_seizureess')->default(false)->nullable();
         $table->boolean('allergy')->default(false)->nullable();

////////////////////يتناول ادوية؟

$table->string('medicine_eat')->nullable();




////////////////////////////////////////////التاريخ الدراسي

    $table->string('training_program')->nullable();


///////////////////////////مستوى اداء الحالي للمستفيد
$table->string('things_make_angry_stressed')->nullable();
$table->string('signs_tension_anger')->nullable();
$table->string('unacceptable_behaviors')->nullable();
$table->string('parents_behave_unacceptable_behaviors_occur')->nullable();
$table->string('responsible_person')->nullable();



///////////////////////////////////مهارات الرعاية الذاتية عند الحالة
$table->string('use_diapers_during_day')->nullable();
$table->string('use_diapers_during_night')->nullable();

$table->boolean('use_bathroom_alone')->default(false)->nullable();
$table->boolean('eat_alone')->default(false)->nullable();
$table->boolean('help_at_home')->default(false)->nullable();
$table->boolean('drink_alone')->default(false)->nullable();
$table->boolean('wear_clother_alone')->default(false)->nullable();
$table->boolean('shower_alone')->default(false)->nullable();
$table->boolean('wash_hands_face_alone')->default(false)->nullable();
$table->boolean('prush_alone')->default(false)->nullable();



////////////////////////////مهارات الاجنماعية
$table->string('relationship_with_parent')->nullable();
$table->string('relationship_with_siblings')->nullable();
$table->string('behave_with_other_children')->nullable();
$table->string('behaves_with_strangers')->nullable();
$table->string('behave_when_he_goesout')->nullable();
$table->string('initiate_kind_social_interaction')->nullable();
$table->string('play_like_other_children')->nullable();

/////////////////////////مهارات التواصل و اللغة
$table->string('use_words_express_himself')->nullable();
$table->string('suffer_from_speech_problems')->nullable();


/////////////////////////////////////////////مهارات اكاديمي

$table->boolean('reading')->default(false)->nullable();
$table->boolean('writing')->default(false)->nullable();
$table->boolean('calculating')->default(false)->nullable();


////////////////////////////////////مهارات الحركية
$table->boolean('walking_skills')->default(false)->nullable();
$table->boolean('running_skills')->default(false)->nullable();
$table->boolean('skill_climb_stairs')->default(false)->nullable();
$table->boolean('jumping_skills')->default(false)->nullable();
$table->boolean('pen_holding_skills')->default(false)->nullable();
$table->boolean('skills_hold_spoon_fork')->default(false)->nullable();
$table->boolean('skills_opening_closing_doors')->default(false)->nullable();

///////////////////////////////////////////الجانب الحسي
$table->boolean('ignore_sensation_pain_heat')->default(false)->nullable();
$table->boolean('ignore_visual_stimuli')->default(false)->nullable();
$table->boolean('ignore_auditory_stimuli')->default(false)->nullable();
$table->boolean('identify_people_things_bysmell')->default(false)->nullable();
$table->boolean('identify_things_tast')->default(false)->nullable();

////////////////////////////////////////اهتمامات الحالة
$table->string('things_liked')->nullable();
$table->string('things_doesnot_liked')->nullable();

//////////////////////////////////////////معلومات كتعلقة بنظرة اسرة الحالة للحالة
$table->string('child_strengths_eyes_family')->nullable();
$table->string('child_weaknesses_eyes_family')->nullable();
$table->string('problems_family_suffers_dealing_with_child')->nullable();
$table->string('skills_family_wants_child_learn')->nullable();
$table->string('skills_child_needs_develop_present_time?')->nullable();


////////////////////////////////////////////////التقرير الختامي
$table->string('expert_opinion')->nullable();
$table->string('services_provided_case')->nullable();
$table->string('proposed_treatment_plan')->nullable();






           $table->timestamps();
           $table->foreign('volunteer_id')->references('id')->on('users')->onDelete('cascade');
           $table->foreign('charities_id')->references('id')->on('charities')->onDelete('cascade');
           $table->foreign('beneficiaries_id')->references('id')->on('beneficiaries')->onDelete('cascade');



       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_forms');
    }
};
