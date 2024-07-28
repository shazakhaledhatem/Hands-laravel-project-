<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'beneficiaries_id',
        'volunteer_id',
        'completion_date',
        'person_filled_form',
        'volunteer_phone',
        'charities_id',
        'gender',
        'name_guardian_family_relationship',
        'type_of_disability',
        'father_phone',
        'mother_phone',
        'the_resident',
        'land_phone',
        'father_name',
        'father_birthdate',
        'father_age',
        'father_education',
        'father_job',
        'mother_name',
        'mother_birthdate',
        'mother_age',
        'mother_education',
        'mother_job',
        'kinship_mother_father',
        'with_whom_case',
        'number_sibling',
        'number_female_brothers',
        'number_male_brothers',
        'resident_name',
        'resident_gender',
        'resident_birthdate',
        'resident_age',
        'resident_healthstatus',
        'resident_education',
        'resident_job',
        'relatives_have_problems',
        'relative_numbers_have_problems',
        'mother_pragnent_age',
        'pragnent_period',
        'pragnent_type',
        'complications_during_pregnancy',
        'medications_during_pregnancy',
        'postpartum_health_issues_birth',
        'surgery',
        'epileptic_seizures',
        'head_injury',
        'infantile_paralysis',
        'metabolic_disorder',
        'allergy_to_some_foods',
        'hearing_problems',
        'optical_problems',
        'speech_problems',
        'epileptic_seizureess',
        'allergy',
        'medicine_eat',
        'training_program',
        'things_make_angry_stressed',
        'signs_tension_anger',
        'unacceptable_behaviors',
        'parents_behave_unacceptable_behaviors_occur',
        'responsible_person',
        'use_diapers_during_day',
        'use_diapers_during_night',
        'use_bathroom_alone',
        'eat_alone',
        'help_at_home',
        'drink_alone',
        'wear_clother_alone',
        'shower_alone',
        'wash_hands_face_alone',
        'prush_alone',
        'relationship_with_parent',
        'relationship_with_siblings',
        'behave_with_other_children',
        'behaves_with_strangers',
        'behave_when_he_goesout',
        'initiate_kind_social_interaction',
        'play_like_other_children',
        'use_words_express_himself',
        'suffer_from_speech_problems',
        'reading',
        'writing',
        'calculating',
        'walking_skills',
        'running_skills',
        'skill_climb_stairs',
        'jumping_skills',
        'pen_holding_skills',
        'skills_hold_spoon_fork',
        'skills_opening_closing_doors',
        'ignore_sensation_pain_heat',
        'ignore_visual_stimuli',
        'ignore_auditory_stimuli',
        'identify_people_things_bysmell',
        'identify_things_tast',
        'things_liked',
        'things_doesnot_liked',
        'child_strengths_eyes_family',
        'child_weaknesses_eyes_family',
        'problems_family_suffers_dealing_with_child',
        'skills_family_wants_child_learn',
        'skills_child_needs_develop_present_time?',
        'expert_opinion',
        'services_provided_case',
        'proposed_treatment_plan',
    ];


    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    public function charity()
    {
        return $this->belongsTo(Charity::class, 'charities_id');
    }

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiaries_id');
    }
}
