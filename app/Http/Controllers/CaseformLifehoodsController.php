<?php

namespace App\Http\Controllers;

use App\Models\caseform_lifehoods;
use App\Models\caseforms;
use App\Models\caseform_lifehood_mid;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class CaseformLifehoodsController extends Controller
{
  public function createlifehoodCaseform(Request $request,$assignId)
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

        'profession_learn' => 'string|nullable',
        'reason_profession' => 'string|nullable',
        'finanical_scholar_support' => 'boolean|nullable',
        'major' => 'string|nullable',
        'year_in_work' => 'string|nullable',
        'knowlodege_you_earn' => 'string|nullable',
        'your_previous_work' => 'string|nullable',

        'looking_for_job' => 'boolean|nullable',
        'type_looking_for_job' => 'string|nullable',
        'apply_job' => 'boolean|nullable',
        'number_request' => 'string|nullable',

        'job_offer' => 'boolean|nullable',
        'what_kind' => 'string|nullable',
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
    $caseformLifehood = caseform_lifehoods::create([
        'profession_learn' => $validatedData['profession_learn'],
        'reason_profession' => $validatedData['reason_profession'],
        'finanical_scholar_support' => $validatedData['finanical_scholar_support'],
        'major' => $validatedData['major'],
        'year_in_work' => $validatedData['year_in_work'],
        'knowlodege_you_earn' => $validatedData['knowlodege_you_earn'],
        'your_previous_work' => $validatedData['your_previous_work'],
        'looking_for_job' => $validatedData['looking_for_job'],

        'type_looking_for_job' => $validatedData['type_looking_for_job'],
        'apply_job' => $validatedData['apply_job'],
        'number_request' => $validatedData['number_request'],
        'job_offer' => $validatedData['job_offer'],
        'what_kind' => $validatedData['what_kind'],

    ]);

    // Create a new CaseformHealthMid record
    $caseformLifehoosMid = caseform_lifehood_mid::create([
        'caseforms_id' => $caseform->id,
        'caseformlifehoods_id' => $caseformLifehood->id,
        'assign_id' => $assignId,
        'date' => $date,
    ]);

    // Return a response or redirect as needed
    return response()->json([
      'status'=>true,
        'message' => 'Caseform Lifehood created successfully!',
        'caseform' => $caseform,
        'caseformLifehood' => $caseformLifehood,
        'caseformLifehoosMid' => $caseformLifehoosMid,
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
