<?php

namespace App\Http\Controllers;

use App\Models\caseform_reliefs;
use App\Models\caseforms;
use App\Models\caseform_relief_mid;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class CaseformReliefsController extends Controller
{
  public function createreliefCaseform(Request $request,$assignId)
{
  $user = Auth::guard('api')->user(); // Authentication for API guard
  if (!$user) {
      return response()->json(['message' => 'Unauthorized'], 401);
  }

  $userId = $user->id;
    // Validate the incoming request data
    $validatedData = $request->validate([
        'main_res' => 'boolean|nullable',
        'main_res_des' => 'string|nullable',
        'add_res' => 'boolean|nullable',
        'add_res_des' => 'string|nullable',
        'diff_cover_monthly_exp' => 'boolean|nullable',
        'loans' => 'boolean|nullable',
        'value_loans' => 'string|nullable',
        'rent_own' => 'string|nullable',
        'type_of_res' => 'string|nullable',
        'rent_value' => 'string|nullable',
        'desc' => 'string|nullable',

        'damage_from_disaster' => 'boolean|nullable',
        'furniture_essitional' => 'boolean|nullable',
        'clothes_for_all_season' => 'boolean|nullable',
        'clothes_for_work_school' => 'boolean|nullable',
        'enough_amount_of_food_daily' => 'boolean|nullable',
        'help_from_organization' => 'boolean|nullable',
        'suffer_psycologic_problem' => 'boolean|nullable',
        'problem_food_plenty_family' => 'boolean|nullable',
      //  'assign_id' => 'integer|nullable',
        'date' => 'date|nullable',
    ]);
    $date = null;
     if (!empty($request->date)) {
         $possibleFormats = ['Y-m-d', 'd/m/Y', 'Y/m/d', 'd-m-Y', 'm-d-Y'];

         foreach ($possibleFormats as $format) {
             try {
                 $date = Carbon::createFromFormat($format, $request->date)->format('Y-m-d');
                 break;
             } catch (\Exception $e) {
                 // Continue to the next format
             }
         }

         if (!$date) {
             return response()->json(['message' => 'Invalid date format'], 400);
         }
     }

    // Create a new Caseform record
    $caseform = caseforms::create([
        'main_res' => $validatedData['main_res'],
        'main_res_des' => $validatedData['main_res_des'],
        'add_res' => $validatedData['add_res'],
        'add_res_des' => $validatedData['add_res_des'],
        'diff_cover_monthly_exp' => $validatedData['diff_cover_monthly_exp'],
        'loans' => $validatedData['loans'],
        'value_loans' => $validatedData['value_loans'],
        'rent_own' => $validatedData['rent_own'],
        'type_of_res' => $validatedData['type_of_res'],
        'rent_value' => $validatedData['rent_value'],
        'desc' => $validatedData['desc'],
    ]);

    // Create a new CaseformHealth record
    $caseformRelief = caseform_reliefs::create([
        'damage_from_disaster' => $validatedData['damage_from_disaster'],
        'furniture_essitional' => $validatedData['furniture_essitional'],
        'clothes_for_all_season' => $validatedData['clothes_for_all_season'],
        'clothes_for_work_school' => $validatedData['clothes_for_work_school'],
        'enough_amount_of_food_daily' => $validatedData['enough_amount_of_food_daily'],
        'help_from_organization' => $validatedData['help_from_organization'],
        'suffer_psycologic_problem' => $validatedData['suffer_psycologic_problem'],
        'problem_food_plenty_family' => $validatedData['problem_food_plenty_family'],


    ]);

    // Create a new CaseformHealthMid record
    $caseformReliefMid = caseform_relief_mid::create([
        'caseforms_id' => $caseform->id,
        'caseformreliefs_id' => $caseformRelief->id,
        'assign_id' => $assignId,
        'date' => $date,
    ]);

    // Return a response or redirect as needed
    return response()->json([
      'status'=>true,
        'message' => 'Caseform Relief created successfully!',
        'caseform' => $caseform,
        'caseformRelief' => $caseformRelief,
        'caseformReliefMid' => $caseformReliefMid,
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
