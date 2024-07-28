<?php

namespace App\Http\Controllers;

use App\Models\assign_orders_volunteer;
use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Models\Beneficiary;
use App\Models\Beneficiary_Education;
use App\Models\Beneficiary_Health;
use App\Models\Beneficiary_Lifehood;
use App\Models\Beneficiary_Relief;
use App\Models\User;
use App\Models\Charity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AssignOrdersVolunteerController extends Controller
{

  public function indexVolunteersname(Request $request)
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
          return response()->json([
              'status' => false,
              'message' => 'Unauthorized',
          ], 401);
      }

      // Validate that the token matches the latest token
      if ($charity->latest_token !== $hashedToken) {
          return response()->json([
              'status' => false,
              'message' => 'Unauthorized: Invalid token',
          ], 401);
      }

      // Check if the token has the required capability
      if (!$charity->tokenCan('Charity Access Token')) {
          return response()->json([
              'status' => false,
              'message' => 'Unauthorized: Token does not have the required capability.',
          ], 403);
      }

      // Get the user ID
      $charityid = $charity->id;
      $volunteernames = Volunteer::where('charities_id', $charityid)
          ->where('status', 'accept')
          ->select('id', 'full_name')
          ->get();

      return response()->json([
          'status' => true,
          'message' => 'get the names successfully',
          'data' => $volunteernames,
          'pagination' => [
              'current_page' => 1,
              'total_pages' => 1,
              'total_items' => $volunteernames->count(),
              'items_per_page' => $volunteernames->count(),
          ],
      ], 200);
  }

    public function assignordersvolunteer(Request $request, $volunteerId, $beneficiaryId)
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
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        // Validate that the token matches the latest token
        if ($charity->latest_token !== $hashedToken) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: Invalid token',
            ], 401);
        }

        // Check if the token has the required capability
        if (!$charity->tokenCan('Charity Access Token')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: Token does not have the required capability.',
            ], 403);
        }

        // Get the user ID
        $charityid = $charity->id;

        // Retrieve education details
        $education_charities = DB::table('beneficiary__education')
            ->where('beneficiaries_id', $beneficiaryId)
            ->first();

        // Retrieve health details
        $health_charities = DB::table('beneficiary__healths')
            ->where('beneficiaries_id', $beneficiaryId)
            ->first();

        // Retrieve relief details
        $relief_charities = DB::table('beneficiary__reliefs')
            ->where('beneficiaries_id', $beneficiaryId)
            ->first();

        // Retrieve lifehood details
        $lifehood_charities = DB::table('beneficiary__lifehoods')
            ->where('beneficiaries_id', $beneficiaryId)
            ->first();

        // Check status
        $status = null;
        if ($education_charities) {
            $status = $education_charities->status;
        } elseif ($health_charities) {
            $status = $health_charities->status;
        } elseif ($relief_charities) {
            $status = $relief_charities->status;
        } elseif ($lifehood_charities) {
            $status = $lifehood_charities->status;
        }

        if ($status == 'approved') {
            $assign = assign_orders_volunteer::create([
                'beneficiaries_id' => $beneficiaryId,
                'charities_id' => $charityid,
                'volunteers_id' => $volunteerId,
                'description' => $request->description,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'assign order successfully',
                'data' => $assign,
                'pagination' => [
                    'current_page' => 1,
                    'total_pages' => 1,
                    'total_items' => 1,
                    'items_per_page' => 1,
                ],
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Beneficiary not approved.',
            ], 400);
        }
    }


    public function getAssignedFormCaseToVolunteer(Request $request)
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
        $user = Auth::guard('api')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        // Validate that the token matches the latest token
        if ($user->latest_token !== $hashedToken) {
            return response()->json(['status' => false, 'message' => 'Unauthorized: Invalid token'], 401);
        }

        // Check if the token has the required capability
        if (!$user->tokenCan('API TOKEN')) {
            return response()->json(['status' => false, 'message' => 'Unauthorized: Token does not have the required capability.'], 403);
        }

        $userId = $user->id;

        $volunteer = Volunteer::where('users_id', $userId)->first();
        if (!$volunteer) {
            return response()->json(['status' => true, 'message' => 'No assiged case form found for this volunteer'], 200);
        }
        $volunteer_id = $volunteer->id;

        $assigned_volunteers = assign_orders_volunteer::where('volunteers_id', $volunteer_id)->get();
        $beneficiary_data = [];

        // Iterate over the assigned volunteer records to get the beneficiaries_id
        foreach ($assigned_volunteers as $assignment) {
            $beneficiary = Beneficiary::find($assignment->beneficiaries_id);
            $charity = Charity::find($assignment->charities_id);

            if ($beneficiary) {
              //  $fullName = $beneficiary? $beneficiary->first_name . ' ' . $beneficiary->last_name : '';

                // Health data
                $beneficiary_health = DB::table('beneficiary__healths')
                    ->where('beneficiaries_id', $assignment->beneficiaries_id)
                    ->get();
                if ($beneficiary_health->isNotEmpty()) {
                    $healthIds = $beneficiary_health->pluck('healths_id')->unique()->toArray();
                    $health = DB::table('healths')->whereIn('id', $healthIds)->get()->keyBy('id');
                    $beneficiary_health = $beneficiary_health->map(function ($item) use ($beneficiary, $health) {
                        $item->beneficiary = $beneficiary;
                        $item->health = $health[$item->healths_id] ?? null;
                        return $item;
                    });
                    $beneficiary_data[] = [
                        'type' => 'Health',
                        //'user' => $fullName,
                        'charity' => $charity ? $charity->name : '',
                        'description' => $assignment->description,
                        'data' => $beneficiary_health
                    ];
                }

                // Education data
                $beneficiary_education = DB::table('beneficiary__education')
                    ->where('beneficiaries_id', $assignment->beneficiaries_id)
                    ->get();
                if ($beneficiary_education->isNotEmpty()) {
                    $educationIds = $beneficiary_education->pluck('education_id')->unique()->toArray();
                    $education = DB::table('education')->whereIn('id', $educationIds)->get()->keyBy('id');
                    $beneficiary_education = $beneficiary_education->map(function ($item) use ($beneficiary, $education) {
                        $item->beneficiary = $beneficiary;
                        $item->education = $education[$item->education_id] ?? null;
                        return $item;
                    });
                    $beneficiary_data[] = [
                        'type' => 'Education',
                        //'user' => $fullName,
                        'charity' => $charity ? $charity->name : '',
                        'description' => $assignment->description,
                        'data' => $beneficiary_education
                    ];
                }

                // Lifehood data
                $beneficiary_lifehood = DB::table('beneficiary__lifehoods')
                    ->where('beneficiaries_id', $assignment->beneficiaries_id)
                    ->get();
                if ($beneficiary_lifehood->isNotEmpty()) {
                    $lifehoodIds = $beneficiary_lifehood->pluck('lifehoods_id')->unique()->toArray();
                    $lifehood = DB::table('life_hoods')->whereIn('id', $lifehoodIds)->get()->keyBy('id');
                    $beneficiary_lifehood = $beneficiary_lifehood->map(function ($item) use ($beneficiary, $lifehood) {
                        $item->beneficiary = $beneficiary;
                        $item->lifehood = $lifehood[$item->lifehoods_id] ?? null;
                        return $item;
                    });
                    $beneficiary_data[] = [
                        'type' => 'Lifehood',
                        //'user' => $fullName,
                        'charity' => $charity ? $charity->name : '',
                        'description' => $assignment->description,
                        'data' => $beneficiary_lifehood
                    ];
                }

                // Relief data
                $beneficiary_relief = DB::table('beneficiary__reliefs')
                    ->where('beneficiaries_id', $assignment->beneficiaries_id)
                    ->get();
                if ($beneficiary_relief->isNotEmpty()) {
                    $reliefIds = $beneficiary_relief->pluck('reliefs_id')->unique()->toArray();
                    $relief = DB::table('reliefs')->whereIn('id', $reliefIds)->get()->keyBy('id');
                    $beneficiary_relief = $beneficiary_relief->map(function ($item) use ($beneficiary, $relief) {
                        $item->beneficiary = $beneficiary;
                        $item->relief = $relief[$item->reliefs_id] ?? null;
                        return $item;
                    });
                    $beneficiary_data[] = [
                        'type' => 'Relief',
                      //  'user' => $fullName,
                        'charity' => $charity ? $charity->name : '',
                        'description' => $assignment->description,
                        'data' => $beneficiary_relief
                    ];
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Assigned case forms retrieved successfully',
            'data' => $beneficiary_data,
            'pagination' => [
                'current_page' => 1,
                'total_pages' => 1,
                'total_items' => count($beneficiary_data),
                'items_per_page' => count($beneficiary_data),
            ],
        ], 200);
    }
}
