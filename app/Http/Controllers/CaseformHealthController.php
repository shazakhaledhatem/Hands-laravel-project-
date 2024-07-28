<?php

namespace App\Http\Controllers;

use App\Models\caseform_health;
use App\Models\caseforms;
use App\Models\caseform_health_mid;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
class CaseformHealthController extends Controller
{
  public function createhealthCaseform(Request $request,$assignId)
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

        'insourance' => 'boolean|nullable',
        'type_ins' => 'string|nullable',
        'main_pro' => 'string|nullable',
        'suffer_time' => 'string|nullable',
        'inh_history' => 'boolean|nullable',
        'inh_history_name' => 'string|nullable',
        'surgery' => 'boolean|nullable',
        'surgery_name' => 'string|nullable',
        'symptom' => 'string|nullable',
        'symptom_time' => 'string|nullable',
        'time_cond' => 'string|nullable',
        'daily_effect' => 'string|nullable',
        'pirman_medicine' => 'boolean|nullable',
        'priman_name' => 'string|nullable',

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
    $caseformHealth = caseform_health::create([
        'insourance' => $validatedData['insourance'],
        'type_ins' => $validatedData['type_ins'],
        'main_pro' => $validatedData['main_pro'],
        'suffer_time' => $validatedData['suffer_time'],
        'inh_history' => $validatedData['inh_history'],
        'inh_history_name' => $validatedData['inh_history_name'],
        'surgery' => $validatedData['surgery'],
        'surgery_name' => $validatedData['surgery_name'],
        'symptom' => $validatedData['symptom'],
        'symptom_time' => $validatedData['symptom_time'],
        'time_cond' => $validatedData['time_cond'],
        'daily_effect' => $validatedData['daily_effect'],
        'pirman_medicine' => $validatedData['pirman_medicine'],
        'priman_name' => $validatedData['priman_name'],
    ]);

    // Create a new CaseformHealthMid record
    $caseformHealthMid = caseform_health_mid::create([
        'caseforms_id' => $caseform->id,
        'caseformhealths_id' => $caseformHealth->id,
        'assign_id' => $assignId,
        'date' => $date,
    ]);

    // Return a response or redirect as needed
    return response()->json([
      'status'=>true,
        'message' => 'Caseform Health created successfully!',
        'caseform' => $caseform,
        'caseformHealth' => $caseformHealth,
        'caseformHealthMid' => $caseformHealthMid,
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
