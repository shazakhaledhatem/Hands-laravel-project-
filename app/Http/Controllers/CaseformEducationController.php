<?php

namespace App\Http\Controllers;

use App\Models\caseform_education;
use App\Models\caseform_education_mid;
use App\Models\caseforms;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class CaseformEducationController extends Controller
{
  public function createducationCaseform(Request $request,$assignId)
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

        'class' => 'string|nullable',
        'school_name' => 'string|nullable',
        'number_of_year_delay' => 'string|nullable',
        'reason_of_delay' => 'string|nullable',
        'times_to_buy_clothes_during_year' => 'string|nullable',
        'cost_of_tools_in_semester' => 'string|nullable',
        'participate_in_courses' => 'boolean|nullable',
        'participate_in_courses_name' => 'string|nullable',
        'need_courses' => 'boolean|nullable',
        'courses_name' => 'string|nullable',
        'many_times_change_bages' => 'string|nullable',
        'any_hopies' => 'string|nullable',
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
    $caseformEducation = caseform_education::create([
        'class' => $validatedData['class'],
        'school_name' => $validatedData['school_name'],
        'number_of_year_delay' => $validatedData['number_of_year_delay'],
        'reason_of_delay' => $validatedData['reason_of_delay'],
        'times_to_buy_clothes_during_year' => $validatedData['times_to_buy_clothes_during_year'],
        'cost_of_tools_in_semester' => $validatedData['cost_of_tools_in_semester'],
        'participate_in_courses' => $validatedData['participate_in_courses'],
        'participate_in_courses_name' => $validatedData['participate_in_courses_name'],
        'need_courses' => $validatedData['need_courses'],
        'courses_name' => $validatedData['courses_name'],
        'many_times_change_bages' => $validatedData['many_times_change_bages'],
        'any_hopies' => $validatedData['any_hopies'],

    ]);

    // Create a new CaseformHealthMid record
    $caseformEducationMid = caseform_education_mid::create([
        'caseforms_id' => $caseform->id,
        'caseformeducations_id' => $caseformEducation->id,
        'assign_id' => $assignId,
        'date' => $date,
    ]);

    // Return a response or redirect as needed
    return response()->json([
      'status'=>true,
        'message' => 'Caseform Education created successfully!',
        'caseform' => $caseform,
        'caseformEducation' => $caseformEducation,
        'caseformEducationMid' => $caseformEducationMid,
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
