<?php

namespace App\Http\Controllers;

use App\Models\CaseForm;
use Illuminate\Http\Request;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CaseFormController extends Controller
{
  public function store(Request $request, $beneId, $charityId)
{
    $user = Auth::guard('api')->user(); // Assuming you have a user method returning the charity
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $userid = $user->id;

    // Define validation rules
    $validator = Validator::make($request->all(), [
        //'beneficiaries_id' => 'required|exists:beneficiaries,id',
        // 'volunteer_id' => 'required|exists:users,id',
        'completion_date' => 'required|date',
        'person_filled_form' => 'required|string|max:255',
        'volunteer_phone' => 'required|string|max:255',
        //'charities_id' => 'required|exists:charities,id',
        'gender' => 'required|string|max:255',
        'name_guardian_family_relationship' => 'nullable|string|max:255',
        'type_of_disability' => 'nullable|string|max:255',
        'father_phone' => 'nullable|string|max:255',
        'mother_phone' => 'nullable|string|max:255',
        'the_resident' => 'nullable|string|max:255',
        'land_phone' => 'nullable|string|max:255',
        'father_name' => 'nullable|string|max:255',
        'father_birthdate' => 'nullable|date',
        'father_age' => 'nullable|integer',
        'father_education' => 'nullable|string|max:255',
        'father_job' => 'nullable|string|max:255',
        'mother_name' => 'nullable|string|max:255',
        'mother_birthdate' => 'nullable|date',
        'mother_age' => 'nullable|integer',
        'mother_education' => 'nullable|string|max:255',
        'mother_job' => 'nullable|string|max:255',
        'kinship_mother_father' => 'nullable|string|max:255',
        'with_whom_case' => 'nullable|string|max:255',
        'number_sibling' => 'nullable|integer',
        'number_female_brothers' => 'nullable|integer',
        'number_male_brothers' => 'nullable|integer',
        'resident_name' => 'nullable|string|max:255',
        'resident_gender' => 'nullable|string|max:255',
        'resident_birthdate' => 'nullable|date',
        'resident_age' => 'nullable|integer',
        'resident_healthstatus' => 'nullable|string|max:255',
        'resident_education' => 'nullable|string|max:255',
        'resident_job' => 'nullable|string|max:255',
        'relatives_have_problems' => 'nullable|boolean',
        'relative_numbers_have_problems' => 'nullable|integer',
        'mother_pragnent_age' => 'nullable|integer',
        'pragnent_period' => 'nullable|integer',
        'pragnent_type' => 'nullable|string|in:normal,unnormal',
        'complications_during_pregnancy' => 'nullable|string|max:255',
        'medications_during_pregnancy' => 'nullable|string|max:255',
        'postpartum_health_issues_birth' => 'nullable|string|max:255',
        'surgery' => 'nullable|boolean',
        'epileptic_seizures' => 'nullable|boolean',
        'head_injury' => 'nullable|boolean',
        'infantile_paralysis' => 'nullable|boolean',
        'metabolic_disorder' => 'nullable|boolean',
        'allergy_to_some_foods' => 'nullable|string|max:255',
        'hearing_problems' => 'nullable|boolean',
        'optical_problems' => 'nullable|boolean',
        'speech_problems' => 'nullable|boolean',
        'epileptic_seizureess' => 'nullable|boolean',
        'allergy' => 'nullable|boolean',
        'medicine_eat' => 'nullable|string|max:255',
        'training_program' => 'nullable|string|max:255',
        'things_make_angry_stressed' => 'nullable|string|max:255',
        'signs_tension_anger' => 'nullable|string|max:255',
        'unacceptable_behaviors' => 'nullable|string|max:255',
        'parents_behave_unacceptable_behaviors_occur' => 'nullable|string|max:255',
        'responsible_person' => 'nullable|string|max:255',
        'use_diapers_during_day' => 'nullable|string|max:255',
        'use_diapers_during_night' => 'nullable|string|max:255',
        'use_bathroom_alone' => 'nullable|boolean',
        'eat_alone' => 'nullable|boolean',
        'help_at_home' => 'nullable|boolean',
        'drink_alone' => 'nullable|boolean',
        'wear_clother_alone' => 'nullable|boolean',
        'shower_alone' => 'nullable|boolean',
        'wash_hands_face_alone' => 'nullable|boolean',
        'prush_alone' => 'nullable|boolean',
        'relationship_with_parent' => 'nullable|string|max:255',
        'relationship_with_siblings' => 'nullable|string|max:255',
        'behave_with_other_children' => 'nullable|string|max:255',
        'behaves_with_strangers' => 'nullable|string|max:255',
        'behave_when_he_goesout' => 'nullable|string|max:255',
        'initiate_kind_social_interaction' => 'nullable|string|max:255',
        'play_like_other_children' => 'nullable|string|max:255',
        'use_words_express_himself' => 'nullable|string|max:255',
        'suffer_from_speech_problems' => 'nullable|string|max:255',
        'reading' => 'nullable|boolean',
        'writing' => 'nullable|boolean',
        'calculating' => 'nullable|boolean',
        'walking_skills' => 'nullable|boolean',
        'running_skills' => 'nullable|boolean',
        'skill_climb_stairs' => 'nullable|boolean',
        'jumping_skills' => 'nullable|boolean',
        'pen_holding_skills' => 'nullable|boolean',
        'skills_hold_spoon_fork' => 'nullable|boolean',
        'skills_opening_closing_doors' => 'nullable|boolean',
        'ignore_sensation_pain_heat' => 'nullable|boolean',
        'ignore_visual_stimuli' => 'nullable|boolean',
        'ignore_auditory_stimuli' => 'nullable|boolean',
        'identify_people_things_bysmell' => 'nullable|boolean',
        'identify_things_tast' => 'nullable|boolean',
        'things_liked' => 'nullable|string|max:255',
        'things_doesnot_liked' => 'nullable|string|max:255',
        'child_strengths_eyes_family' => 'nullable|string|max:255',
        'child_weaknesses_eyes_family' => 'nullable|string|max:255',
        'problems_family_suffers_dealing_with_child' => 'nullable|string|max:255',
        'skills_family_wants_child_learn' => 'nullable|string|max:255',
        'skills_child_needs_develop_present_time' => 'nullable|string|max:255',
        'expert_opinion' => 'nullable|string|max:255',
        'services_provided_case' => 'nullable|string|max:255',
        'proposed_treatment_plan' => 'nullable|string|max:255',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors(),
        ], 422);
    }

  /*  $order = Beneficiary::where('id', $beneId)->first();

    if ($order->charities_id != $charityId) {
        return response()->json([
            'status' => false,
            'message' => 'this order not belong to this charity',
        ], 422);
    }*/

    // Validation passed, create the case form
    try {
        $caseForm = CaseForm::create([
            'beneficiaries_id' => $beneId,
            'volunteer_id' => $userid,
            'completion_date' => $request->input('completion_date'),
            'person_filled_form' => $request->input('person_filled_form'),
            'volunteer_phone' => $request->input('volunteer_phone'),
            'charities_id' => $charityId,
            'gender' => $request->input('gender'),
            'name_guardian_family_relationship' => $request->input('name_guardian_family_relationship'),
            'type_of_disability' => $request->input('type_of_disability'),
            'father_phone' => $request->input('father_phone'),
            'mother_phone' => $request->input('mother_phone'),
            'the_resident' => $request->input('the_resident'),
            'land_phone' => $request->input('land_phone'),
            'father_name' => $request->input('father_name'),
            'father_birthdate' => $request->input('father_birthdate'),
            'father_age' => $request->input('father_age'),
            'father_education' => $request->input('father_education'),
            'father_job' => $request->input('father_job'),
            'mother_name' => $request->input('mother_name'),
            'mother_birthdate' => $request->input('mother_birthdate'),
            'mother_age' => $request->input('mother_age'),
            'mother_education' => $request->input('mother_education'),
            'mother_job' => $request->input('mother_job'),
            'kinship_mother_father' => $request->input('kinship_mother_father'),
            'with_whom_case' => $request->input('with_whom_case'),
            'number_sibling' => $request->input('number_sibling'),
            'number_female_brothers' => $request->input('number_female_brothers'),
            'number_male_brothers' => $request->input('number_male_brothers'),
            'resident_name' => $request->input('resident_name'),
            'resident_gender' => $request->input('resident_gender'),
            'resident_birthdate' => $request->input('resident_birthdate'),
            'resident_age' => $request->input('resident_age'),
            'resident_healthstatus' => $request->input('resident_healthstatus'),
            'resident_education' => $request->input('resident_education'),
            'resident_job' => $request->input('resident_job'),
            'relatives_have_problems' => $request->input('relatives_have_problems'),
            'relative_numbers_have_problems' => $request->input('relative_numbers_have_problems'),
            'mother_pragnent_age' => $request->input('mother_pragnent_age'),
            'pragnent_period' => $request->input('pragnent_period'),
            'pragnent_type' => $request->input('pragnent_type'),
            'complications_during_pregnancy' => $request->input('complications_during_pregnancy'),
            'medications_during_pregnancy' => $request->input('medications_during_pregnancy'),
            'postpartum_health_issues_birth' => $request->input('postpartum_health_issues_birth'),
            'surgery' => $request->input('surgery'),
            'epileptic_seizures' => $request->input('epileptic_seizures'),
            'head_injury' => $request->input('head_injury'),
            'infantile_paralysis' => $request->input('infantile_paralysis'),
            'metabolic_disorder' => $request->input('metabolic_disorder'),
            'allergy_to_some_foods' => $request->input('allergy_to_some_foods'),
            'hearing_problems' => $request->input('hearing_problems'),
            'optical_problems' => $request->input('optical_problems'),
            'speech_problems' => $request->input('speech_problems'),
            'epileptic_seizureess' => $request->input('epileptic_seizureess'),
            'allergy' => $request->input('allergy'),
            'medicine_eat' => $request->input('medicine_eat'),
            'training_program' => $request->input('training_program'),
            'things_make_angry_stressed' => $request->input('things_make_angry_stressed'),
            'signs_tension_anger' => $request->input('signs_tension_anger'),
            'unacceptable_behaviors' => $request->input('unacceptable_behaviors'),
            'parents_behave_unacceptable_behaviors_occur' => $request->input('parents_behave_unacceptable_behaviors_occur'),
            'responsible_person' => $request->input('responsible_person'),
            'use_diapers_during_day' => $request->input('use_diapers_during_day'),
            'use_diapers_during_night' => $request->input('use_diapers_during_night'),
            'use_bathroom_alone' => $request->input('use_bathroom_alone'),
            'eat_alone' => $request->input('eat_alone'),
            'help_at_home' => $request->input('help_at_home'),
            'drink_alone' => $request->input('drink_alone'),
            'wear_clother_alone' => $request->input('wear_clother_alone'),
            'shower_alone' => $request->input('shower_alone'),
            'wash_hands_face_alone' => $request->input('wash_hands_face_alone'),
            'prush_alone' => $request->input('prush_alone'),
            'relationship_with_parent' => $request->input('relationship_with_parent'),
            'relationship_with_siblings' => $request->input('relationship_with_siblings'),
            'behave_with_other_children' => $request->input('behave_with_other_children'),
            'behaves_with_strangers' => $request->input('behaves_with_strangers'),
            'behave_when_he_goesout' => $request->input('behave_when_he_goesout'),
            'initiate_kind_social_interaction' => $request->input('initiate_kind_social_interaction'),
            'play_like_other_children' => $request->input('play_like_other_children'),
            'use_words_express_himself' => $request->input('use_words_express_himself'),
            'suffer_from_speech_problems' => $request->input('suffer_from_speech_problems'),
            'reading' => $request->input('reading'),
            'writing' => $request->input('writing'),
            'calculating' => $request->input('calculating'),
            'walking_skills' => $request->input('walking_skills'),
            'running_skills' => $request->input('running_skills'),
            'skill_climb_stairs' => $request->input('skill_climb_stairs'),
            'jumping_skills' => $request->input('jumping_skills'),
            'pen_holding_skills' => $request->input('pen_holding_skills'),
            'skills_hold_spoon_fork' => $request->input('skills_hold_spoon_fork'),
            'skills_opening_closing_doors' => $request->input('skills_opening_closing_doors'),
            'ignore_sensation_pain_heat' => $request->input('ignore_sensation_pain_heat'),
            'ignore_visual_stimuli' => $request->input('ignore_visual_stimuli'),
            'ignore_auditory_stimuli' => $request->input('ignore_auditory_stimuli'),
            'identify_people_things_bysmell' => $request->input('identify_people_things_bysmell'),
            'identify_things_tast' => $request->input('identify_things_tast'),
            'things_liked' => $request->input('things_liked'),
            'things_doesnot_liked' => $request->input('things_doesnot_liked'),
            'child_strengths_eyes_family' => $request->input('child_strengths_eyes_family'),
            'child_weaknesses_eyes_family' => $request->input('child_weaknesses_eyes_family'),
            'problems_family_suffers_dealing_with_child' => $request->input('problems_family_suffers_dealing_with_child'),
            'skills_family_wants_child_learn' => $request->input('skills_family_wants_child_learn'),
            'skills_child_needs_develop_present_time?' => $request->input('skills_child_needs_develop_present_time?'),
            'expert_opinion' => $request->input('expert_opinion'),
            'services_provided_case' => $request->input('services_provided_case'),
            'proposed_treatment_plan' => $request->input('proposed_treatment_plan'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Form created successfully',
            'data' => $caseForm,
            'pagination' => [
                'current_page' =>1,
                'total_pages' => 1,
                'total_items' => 1,
                'items_per_page' =>1,
                'first_item' => 1,
                'last_item' =>1,
                'has_more_pages' =>1,
                'next_page_url' =>1,
                'previous_page_url' => 1,
            ],
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'An error occurred while creating the form',
            'error' => $e->getMessage(),
        ], 500);
    }
}



public function update(Request $request, $caseFormId)
{
    $user = Auth::guard('api')->user(); // Assuming you have a user method returning the charity
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $userid = $user->id;

    // Define validation rules
    $validator = Validator::make($request->all(), [
        'completion_date' => 'required|date',
        'person_filled_form' => 'required|string|max:255',
        'volunteer_phone' => 'required|string|max:255',
        'gender' => 'required|string|max:255',
        'name_guardian_family_relationship' => 'nullable|string|max:255',
        'type_of_disability' => 'nullable|string|max:255',
        'father_phone' => 'nullable|string|max:255',
        'mother_phone' => 'nullable|string|max:255',
        'the_resident' => 'nullable|string|max:255',
        'land_phone' => 'nullable|string|max:255',
        'father_name' => 'nullable|string|max:255',
        'father_birthdate' => 'nullable|date',
        'father_age' => 'nullable|integer',
        'father_education' => 'nullable|string|max:255',
        'father_job' => 'nullable|string|max:255',
        'mother_name' => 'nullable|string|max:255',
        'mother_birthdate' => 'nullable|date',
        'mother_age' => 'nullable|integer',
        'mother_education' => 'nullable|string|max:255',
        'mother_job' => 'nullable|string|max:255',
        'kinship_mother_father' => 'nullable|string|max:255',
        'with_whom_case' => 'nullable|string|max:255',
        'number_sibling' => 'nullable|integer',
        'number_female_brothers' => 'nullable|integer',
        'number_male_brothers' => 'nullable|integer',
        'resident_name' => 'nullable|string|max:255',
        'resident_gender' => 'nullable|string|max:255',
        'resident_birthdate' => 'nullable|date',
        'resident_age' => 'nullable|integer',
        'resident_healthstatus' => 'nullable|string|max:255',
        'resident_education' => 'nullable|string|max:255',
        'resident_job' => 'nullable|string|max:255',
        'relatives_have_problems' => 'nullable|boolean',
        'relative_numbers_have_problems' => 'nullable|integer',
        'mother_pragnent_age' => 'nullable|integer',
        'pragnent_period' => 'nullable|integer',
        'pragnent_type' => 'nullable|string|in:normal,unnormal',
        'complications_during_pregnancy' => 'nullable|string|max:255',
        'medications_during_pregnancy' => 'nullable|string|max:255',
        'postpartum_health_issues_birth' => 'nullable|string|max:255',
        'surgery' => 'nullable|boolean',
        'epileptic_seizures' => 'nullable|boolean',
        'head_injury' => 'nullable|boolean',
        'infantile_paralysis' => 'nullable|boolean',
        'metabolic_disorder' => 'nullable|boolean',
        'allergy_to_some_foods' => 'nullable|string|max:255',
        'hearing_problems' => 'nullable|boolean',
        'optical_problems' => 'nullable|boolean',
        'speech_problems' => 'nullable|boolean',
        'epileptic_seizureess' => 'nullable|boolean',
        'allergy' => 'nullable|boolean',
        'medicine_eat' => 'nullable|string|max:255',
        'training_program' => 'nullable|string|max:255',
        'things_make_angry_stressed' => 'nullable|string|max:255',
        'signs_tension_anger' => 'nullable|string|max:255',
        'unacceptable_behaviors' => 'nullable|string|max:255',
        'parents_behave_unacceptable_behaviors_occur' => 'nullable|string|max:255',
        'responsible_person' => 'nullable|string|max:255',
        'use_diapers_during_day' => 'nullable|string|max:255',
        'use_diapers_during_night' => 'nullable|string|max:255',
        'use_bathroom_alone' => 'nullable|boolean',
        'eat_alone' => 'nullable|boolean',
        'help_at_home' => 'nullable|boolean',
        'drink_alone' => 'nullable|boolean',
        'wear_clother_alone' => 'nullable|boolean',
        'shower_alone' => 'nullable|boolean',
        'wash_hands_face_alone' => 'nullable|boolean',
        'prush_alone' => 'nullable|boolean',
        'relationship_with_parent' => 'nullable|string|max:255',
        'relationship_with_siblings' => 'nullable|string|max:255',
        'behave_with_other_children' => 'nullable|string|max:255',
        'behaves_with_strangers' => 'nullable|string|max:255',
        'behave_when_he_goesout' => 'nullable|string|max:255',
        'initiate_kind_social_interaction' => 'nullable|string|max:255',
        'play_like_other_children' => 'nullable|string|max:255',
        'use_words_express_himself' => 'nullable|string|max:255',
        'suffer_from_speech_problems' => 'nullable|string|max:255',
        'reading' => 'nullable|boolean',
        'writing' => 'nullable|boolean',
        'calculating' => 'nullable|boolean',
        'walking_skills' => 'nullable|boolean',
        'running_skills' => 'nullable|boolean',
        'skill_climb_stairs' => 'nullable|boolean',
        'jumping_skills' => 'nullable|boolean',
        'pen_holding_skills' => 'nullable|boolean',
        'skills_hold_spoon_fork' => 'nullable|boolean',
        'skills_opening_closing_doors' => 'nullable|boolean',
        'ignore_sensation_pain_heat' => 'nullable|boolean',
        'ignore_visual_stimuli' => 'nullable|boolean',
        'ignore_auditory_stimuli' => 'nullable|boolean',
        'identify_people_things_bysmell' => 'nullable|boolean',
        'identify_things_tast' => 'nullable|boolean',
        'things_liked' => 'nullable|string|max:255',
        'things_doesnot_liked' => 'nullable|string|max:255',
        'child_strengths_eyes_family' => 'nullable|string|max:255',
        'child_weaknesses_eyes_family' => 'nullable|string|max:255',
        'problems_family_suffers_dealing_with_child' => 'nullable|string|max:255',
        'skills_family_wants_child_learn' => 'nullable|string|max:255',
        'skills_child_needs_develop_present_time' => 'nullable|string|max:255',
        'expert_opinion' => 'nullable|string|max:255',
        'services_provided_case' => 'nullable|string|max:255',
        'proposed_treatment_plan' => 'nullable|string|max:255',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Find the case form
    $caseForm = CaseForm::where('id', $caseFormId)
                        ->first();

    if (!$caseForm) {
        return response()->json([
            'status' => false,
            'message' => 'Case form not found',
        ], 404);
    }

    // Validation passed, update the case form
  /*  try {
        $caseForm->update([
            'completion_date' => $request->input('completion_date'),
            'person_filled_form' => $request->input('person_filled_form'),
            'volunteer_phone' => $request->input('volunteer_phone'),
            'gender' => $request->input('gender'),
            'name_guardian_family_relationship' => $request->input('name_guardian_family_relationship'),
            'type_of_disability' => $request->input('type_of_disability'),
            'father_phone' => $request->input('father_phone'),
            'mother_phone' => $request->input('mother_phone'),
            'the_resident' => $request->input('the_resident'),
            'land_phone' => $request->input('land_phone'),
            'father_name' => $request->input('father_name'),
            'father_birthdate' => $request->input('father_birthdate'),
            'father_age' => $request->input('father_age'),
            'father_education' => $request->input('father_education'),
            'father_job' => $request->input('father_job'),
            'mother_name' => $request->input('mother_name'),
            'mother_birthdate' => $request->input('mother_birthdate'),
            'mother_age' => $request->input('mother_age'),
            'mother_education' => $request->input('mother_education'),
            'mother_job' => $request->input('mother_job'),
            'kinship_mother_father' => $request->input('kinship_mother_father'),
            'with_whom_case' => $request->input('with_whom_case'),
            'number_sibling' => $request->input('number_sibling'),
            'number_female_brothers' => $request->input('number_female_brothers'),
            'number_male_brothers' => $request->input('number_male_brothers'),
            'resident_name' => $request->input('resident_name'),
            'resident_gender' => $request->input('resident_gender'),
            'resident_birthdate' => $request->input('resident_birthdate'),
            'resident_age' => $request->input('resident_age'),
            'resident_healthstatus' => $request->input('resident_healthstatus'),
            'resident_education' => $request->input('resident_education'),
            'resident_job' => $request->input('resident_job'),
            'relatives_have_problems' => $request->input('relatives_have_problems'),
            'relative_numbers_have_problems' => $request->input('relative_numbers_have_problems'),
            'mother_pragnent_age' => $request->input('mother_pragnent_age'),
            'pragnent_period' => $request->input('pragnent_period'),
            'pragnent_type' => $request->input('pragnent_type'),
            'complications_during_pregnancy' => $request->input('complications_during_pregnancy'),
            'medications_during_pregnancy' => $request->input('medications_during_pregnancy'),
            'postpartum_health_issues_birth' => $request->input('postpartum_health_issues_birth'),
            'surgery' => $request->input('surgery'),
            'epileptic_seizures' => $request->input('epileptic_seizures'),
            'head_injury' => $request->input('head_injury'),
            'infantile_paralysis' => $request->input('infantile_paralysis'),
            'metabolic_disorder' => $request->input('metabolic_disorder'),
            'allergy_to_some_foods' => $request->input('allergy_to_some_foods'),
            'hearing_problems' => $request->input('hearing_problems'),
            'optical_problems' => $request->input('optical_problems'),
            'speech_problems' => $request->input('speech_problems'),
            'epileptic_seizureess' => $request->input('epileptic_seizureess'),
            'allergy' => $request->input('allergy'),
            'medicine_eat' => $request->input('medicine_eat'),
            'training_program' => $request->input('training_program'),
            'things_make_angry_stressed' => $request->input('things_make_angry_stressed'),
            'signs_tension_anger' => $request->input('signs_tension_anger'),
            'unacceptable_behaviors' => $request->input('unacceptable_behaviors'),
            'parents_behave_unacceptable_behaviors_occur' => $request->input('parents_behave_unacceptable_behaviors_occur'),
            'responsible_person' => $request->input('responsible_person'),
            'use_diapers_during_day' => $request->input('use_diapers_during_day'),
            'use_diapers_during_night' => $request->input('use_diapers_during_night'),
            'use_bathroom_alone' => $request->input('use_bathroom_alone'),
            'eat_alone' => $request->input('eat_alone'),
            'help_at_home' => $request->input('help_at_home'),
            'drink_alone' => $request->input('drink_alone'),
            'wear_clother_alone' => $request->input('wear_clother_alone'),
            'shower_alone' => $request->input('shower_alone'),
            'wash_hands_face_alone' => $request->input('wash_hands_face_alone'),
            'prush_alone' => $request->input('prush_alone'),
            'relationship_with_parent' => $request->input('relationship_with_parent'),
            'relationship_with_siblings' => $request->input('relationship_with_siblings'),
            'behave_with_other_children' => $request->input('behave_with_other_children'),
            'behaves_with_strangers' => $request->input('behaves_with_strangers'),
            'behave_when_he_goesout' => $request->input('behave_when_he_goesout'),
            'initiate_kind_social_interaction' => $request->input('initiate_kind_social_interaction'),
            'play_like_other_children' => $request->input('play_like_other_children'),
            'use_words_express_himself' => $request->input('use_words_express_himself'),
            'suffer_from_speech_problems' => $request->input('suffer_from_speech_problems'),
            'reading' => $request->input('reading'),
            'writing' => $request->input('writing'),
            'calculating' => $request->input('calculating'),
            'walking_skills' => $request->input('walking_skills'),
            'running_skills' => $request->input('running_skills'),
            'skill_climb_stairs' => $request->input('skill_climb_stairs'),
            'jumping_skills' => $request->input('jumping_skills'),
            'pen_holding_skills' => $request->input('pen_holding_skills'),
            'skills_hold_spoon_fork' => $request->input('skills_hold_spoon_fork'),
            'skills_opening_closing_doors' => $request->input('skills_opening_closing_doors'),
            'ignore_sensation_pain_heat' => $request->input('ignore_sensation_pain_heat'),
            'ignore_visual_stimuli' => $request->input('ignore_visual_stimuli'),
            'ignore_auditory_stimuli' => $request->input('ignore_auditory_stimuli'),
            'identify_people_things_bysmell' => $request->input('identify_people_things_bysmell'),
            'identify_things_tast' => $request->input('identify_things_tast'),
            'things_liked' => $request->input('things_liked'),
            'things_doesnot_liked' => $request->input('things_doesnot_liked'),
            'child_strengths_eyes_family' => $request->input('child_strengths_eyes_family'),
            'child_weaknesses_eyes_family' => $request->input('child_weaknesses_eyes_family'),
            'problems_family_suffers_dealing_with_child' => $request->input('problems_family_suffers_dealing_with_child'),
            'skills_family_wants_child_learn' => $request->input('skills_family_wants_child_learn'),
            'skills_child_needs_develop_present_time' => $request->input('skills_child_needs_develop_present_time'),
            'expert_opinion' => $request->input('expert_opinion'),
            'services_provided_case' => $request->input('services_provided_case'),
            'proposed_treatment_plan' => $request->input('proposed_treatment_plan'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Case form updated successfully',
            'data' => $caseForm,
            'pagination' => [
                'current_page' =>1,
                'total_pages' => 1,
                'total_items' => 1,
                'items_per_page' =>1,
                'first_item' => 1,
                'last_item' =>1,
                'has_more_pages' =>1,
                'next_page_url' =>1,
                'previous_page_url' => 1,
            ],
        ], 200);*/
        $data = $request->all();
    // if ($request->has('completion_date')) {
    //     $data['completion_date'] = Carbon::createFromFormat('d-m-Y', $request->completion_date)->format('Y-m-d');
    // }
    if ($request->has('completion_date')) {
        $date = $request->completion_date;

        // Attempt to parse the date in 'd-m-Y' format first
        try {
            $parsedDate = Carbon::createFromFormat('d-m-Y', $date);
            $data['completion_date'] = $parsedDate->format('Y-m-d');
        } catch (\Exception $e) {
            // If parsing fails, attempt to parse in 'Y-m-d' format
            try {
                $parsedDate = Carbon::createFromFormat('Y-m-d', $date);
                $data['completion_date'] = $parsedDate->format('Y-m-d');
            } catch (\Exception $e) {
                // If both parsing attempts fail, handle the error (e.g., set a default value, throw an exception, etc.)
                return response()->json(['message' => 'Invalid date format.'], 400);
            }
        }
    }

    // Update the case form with the provided data
    try {
        $caseForm->update($data);

       return response()->json([
           'status' => true,
           'message' => 'Case form updated successfully',
           'data' => $caseForm,
           'pagination' => [
               'current_page' =>1,
               'total_pages' => 1,
               'total_items' => 1,
               'items_per_page' =>1,
               'first_item' => 1,
               'last_item' =>1,
               'has_more_pages' =>1,
               'next_page_url' =>1,
               'previous_page_url' => 1,
           ],
       ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'An error occurred while updating the case form',
            'error' => $e->getMessage(),
        ], 500);
    }

}

public function index(Request $request)
{
  $token = $request->header('Authorization');
  if (!$token) {
      return response()->json([
          'status' => false,
          'message' => 'Authorization token not provided.',
      ], 401);
  }

  // Remove 'Bearer ' from the token string
  $token = str_replace('Bearer ', '', $token);
  $hashedToken = hash('sha256', $token);

  // Retrieve the authenticated user
  $charity = Auth::guard('api-charities')->user();

  // Check if user is authenticated
  if (!$charity) {
      return response()->json([  'status' => false,'message' => 'Unauthorized'], 401);
  }

  // Validate that the token matches the latest token
  if ($charity->latest_token !== $hashedToken) {
      return response()->json([  'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
  }

  // Check if the token has the required capability
  if (!$charity->tokenCan('Charity Access Token')) {
      return response()->json([  'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
  }


$charityId= $charity->id;

    // Retrieve all case forms for the given beneficiary and charity
    $caseForms = CaseForm::
                         where('charities_id', $charityId)
                      //   ->orderBy('created_at', 'desc') // Example: Order by creation date descending
                         ->paginate(10); // Adjust the number per page as per your requirement

  
    // Return a JSON response with the retrieved case forms
    return response()->json([
        'status' => true,
        'message' => 'Case forms retrieved successfully',
        'data' => $caseForms->items(), // Use ->items() to get the actual data items
        'pagination' => [
            'current_page' => $caseForms->currentPage(),
            'total_pages' => $caseForms->lastPage(),
            'total_items' => $caseForms->total(),
            'items_per_page' => $caseForms->perPage(),
            'first_item' => $caseForms->firstItem(),
            'last_item' => $caseForms->lastItem(),
            'has_more_pages' => $caseForms->hasMorePages(),
            'next_page_url' => $caseForms->nextPageUrl(),
            'previous_page_url' => $caseForms->previousPageUrl(),
        ],
    ], 200);
}


public function show(Request $request, $caseFormId)
{
  $token = $request->header('Authorization');
  if (!$token) {
      return response()->json([
          'status' => false,
          'message' => 'Authorization token not provided.',
      ], 401);
  }

  // Remove 'Bearer ' from the token string
  $token = str_replace('Bearer ', '', $token);
  $hashedToken = hash('sha256', $token);

  // Retrieve the authenticated user
  $charity = Auth::guard('api-charities')->user();

  // Check if user is authenticated
  if (!$charity) {
      return response()->json([  'status' => false,'message' => 'Unauthorized'], 401);
  }

  // Validate that the token matches the latest token
  if ($charity->latest_token !== $hashedToken) {
      return response()->json([  'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
  }

  // Check if the token has the required capability
  if (!$charity->tokenCan('Charity Access Token')) {
      return response()->json([  'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
  }


$charityId= $charity->id;



    // Find the case form by ID and ensure it belongs to the given beneficiary and charity
    $caseForm = CaseForm::where('id', $caseFormId)

                        ->first();

$caseFormId=$caseForm->beneficiaries_id;
$beneficiaries=Beneficiary::where('id',$caseFormId)->first();

    // Check if the case form is found
    if (!$caseForm) {
        return response()->json([
            'status' => false,
            'message' => 'Case form not found for the given beneficiary and charity',
        ], 404);
    }

    // Return a JSON response with the case form details
    return response()->json([
        'status' => true,
        'message' => 'Case form retrieved successfully',
        'data' =>['caseForm'=> $caseForm,
          'beneficiaries'=>$beneficiaries,

      ],
        'pagination' => [
            'current_page' =>1,
            'total_pages' => 1,
            'total_items' => 1,
            'items_per_page' =>1,
            'first_item' => 1,
            'last_item' =>1,
            'has_more_pages' =>1,
            'next_page_url' =>1,
            'previous_page_url' => 1,
        ],
    ], 200);
}

}
