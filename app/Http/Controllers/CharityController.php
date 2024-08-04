<?php

namespace App\Http\Controllers;

use App\Models\Charity;

use App\Models\Volunteer;
use App\Models\Effectiveness;
use App\Models\LocationThatCoveredByCharities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
  use Illuminate\Support\Facades\Http;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Pagination\Paginator;
  use App\Models\Beneficiary;
use App\Models\Beneficiary_Health;
use App\Models\Beneficiary_Education;
use App\Models\Education;
use App\Models\Beneficiary_Relief;
use App\Models\Relief;
use App\Models\Beneficiary_Lifehood;
use App\Models\Lifehood;
use App\Models\Health;
use App\Models\User;
use App\Models\Orderesfromemergencystatus;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

use App\Models\caseform_health;
use App\Models\caseform_education;
use App\Models\caseform_reliefs;
use App\Models\caseform_lifehoods;
use App\Models\caseform_health_mid;
use App\Models\caseform_education_mid;
use App\Models\caseform_relief_mid;
use App\Models\caseform_lifehood_mid;
use App\Models\assign_orders_volunteer;
use App\Models\caseforms;
class CharityController extends Controller
{
  public function acceptorders($id,Request $request)
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

    // Get the user ID
    $charityid = $charity->id;

    $tables = ['beneficiary__healths', 'beneficiary__education', 'beneficiary__reliefs', 'beneficiary__lifehoods'];

    $data = null;

  foreach ($tables as $table) {
      $record = DB::table($table)->where('beneficiaries_id', $id)->first();
      if ($record) {
          $data = $record;
          break;
      }
  }

  if ($data) {
      $data = (array) $data; // Convert stdClass to array
      $data['status'] = "approved";
        $data['charities_id']=$charityid;
      DB::table($table)->where('beneficiaries_id', $id)->update(['charities_id'=>$charityid,
        'status' => 'approved']);

      // Dump and die to check the updated data

  } else {
      dd('ID does not exist in any of the tables.');
  }
return response()->json([
'status' => true,
'message' => 'charity accept the order',
'data'=>$data ,

'pagination' => [
    'current_page' => 1,
    'total_pages' => 1,
    'total_items' =>1,
    'items_per_page' =>1,

],
],200);

  }

  public function rejectorders($id,Request $request)
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

    // Get the user ID
    $charityid = $charity->id;
    $tables = ['beneficiary__healths', 'beneficiary__education', 'beneficiary__reliefs', 'beneficiary__lifehoods'];
  $data = null;

  foreach ($tables as $table) {
      $record = DB::table($table)->where('beneficiaries_id', $id)->first();
      if ($record) {
          $data = $record;
          break;
      }
  }

  if ($data) {
      $data = (array) $data;
      $data['status'] = "rejected";
    $data['charities_id']=$charityid;
      DB::table($table)->where('beneficiaries_id', $id)->update(['charities_id'=>$charityid,
        'status' => 'rejected']);



  } else {
      dd('ID does not exist in any of the tables.');
  }
return response()->json([
'status' => true,
'message' => 'charity rejected the order',
'data'=>$data ,

'pagination' => [
    'current_page' => 1,
    'total_pages' => 1,
    'total_items' =>1,
    'items_per_page' =>1,

],
],200);

  }

  /////////////////////////////////////completed Orderes

  public function completedorders($id,Request $request)
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

    // Get the user ID
    $charityid = $charity->id;

    $tables = ['beneficiary__healths', 'beneficiary__education', 'beneficiary__reliefs', 'beneficiary__lifehoods'];

    $data = null;

  foreach ($tables as $table) {
      $record = DB::table($table)->where('beneficiaries_id', $id)->first();
      if ($record) {
          $data = $record;
          break;
      }
  }

  if ($data) {
      $data = (array) $data; // Convert stdClass to array
      $data['status'] = "completed";
        $data['charities_id']=$charityid;
      DB::table($table)->where('beneficiaries_id', $id)->update(['charities_id'=>$charityid,
        'status' => 'completed']);

      // Dump and die to check the updated data

  } else {
      dd('ID does not exist in any of the tables.');
  }
return response()->json([
'status' => true,
'message' => 'charity completed the order',
'data'=>$data ,

'pagination' => [
    'current_page' => 1,
    'total_pages' => 1,
    'total_items' =>1,
    'items_per_page' =>1,

],
],200);

  }
  /////////////////////////////////////////////transformed order to case forms

  public function transformedorderstocaseform($id,Request $request)
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

    // Get the user ID
    $charityid = $charity->id;

    $tables = ['beneficiary__healths', 'beneficiary__education', 'beneficiary__reliefs', 'beneficiary__lifehoods'];

    $data = null;

  foreach ($tables as $table) {
      $record = DB::table($table)->where('beneficiaries_id', $id)->first();
      if ($record) {
          $data = $record;
          break;
      }
  }

  if ($data) {
      $data = (array) $data; // Convert stdClass to array
      $data['status'] = "transformed";
        $data['charities_id']=$charityid;
      DB::table($table)->where('beneficiaries_id', $id)->update(['charities_id'=>$charityid,
        'status' => 'transformed']);

      // Dump and die to check the updated data

  } else {
      dd('ID does not exist in any of the tables.');
  }
return response()->json([
'status' => true,
'message' => 'charity transformed the order to complete case form for it.',
'data'=>$data ,

'pagination' => [
    'current_page' => 1,
    'total_pages' => 1,
    'total_items' =>1,
    'items_per_page' =>1,

],
],200);

  }
  ////////////////////////////////////////////////



//هون عم اعرض كل الطلبات
public function indexorderspending(Request $request)
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

  $charityId = $charity->id;

  // Fetch beneficiary health data
  $beneficiary_health = DB::table('beneficiary__healths')
      ->where('charities_id', $charityId)
      ->where('status', '!=', 'rejected')
      ->get();
  $beneficiaryIds = $beneficiary_health->pluck('beneficiaries_id')->unique()->toArray();
  $beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');
  $beneficiaryUserIds = $beneficiaries->pluck('users_id')->unique()->toArray();
  $users = User::whereIn('id', $beneficiaryUserIds)->get();
  $firstName = '';
  $lastName = '';
  foreach ($users as $user) {
      $firstName = $user->firstName;
      $lastName = $user->lastName;
  }
  $fullName = $firstName . ' ' . $lastName;
  $healthIds = $beneficiary_health->pluck('healths_id')->unique()->toArray();
  $health = DB::table('healths')->whereIn('id', $healthIds)->get()->keyBy('id');
  $beneficiary_health = $beneficiary_health->map(function ($item) use ($beneficiaries, $health) {
      $item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
      $item->health = $health[$item->healths_id] ?? null;
      return $item;
  });

  // Fetch beneficiary education data
  $beneficiary_education = DB::table('beneficiary__education')
      ->where('charities_id', $charityId)
      ->where('status', '!=', 'rejected')
      ->get();
  $beneficiaryIds = $beneficiary_education->pluck('beneficiaries_id')->unique()->toArray();
  $beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');
  $educationIds = $beneficiary_education->pluck('education_id')->unique()->toArray();
  $education = DB::table('education')->whereIn('id', $educationIds)->get()->keyBy('id');
  $beneficiary_education = $beneficiary_education->map(function ($item) use ($beneficiaries, $education) {
      $item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
      $item->education = $education[$item->education_id] ?? null;
      return $item;
  });

  // Fetch beneficiary lifehood data
  $beneficiary_lifehood = DB::table('beneficiary__lifehoods')
      ->where('charities_id', $charityId)
      ->where('status', '!=', 'rejected')
      ->get();
  $beneficiaryIds = $beneficiary_lifehood->pluck('beneficiaries_id')->unique()->toArray();
  $beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');
  $lifehoodIds = $beneficiary_lifehood->pluck('lifehoods_id')->unique()->toArray();
  $lifehood = DB::table('life_hoods')->whereIn('id', $lifehoodIds)->get()->keyBy('id');
  $beneficiary_lifehood = $beneficiary_lifehood->map(function ($item) use ($beneficiaries, $lifehood) {
      $item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
      $item->lifehood = $lifehood[$item->lifehoods_id] ?? null;
      return $item;
  });

  // Fetch beneficiary relief data
  $beneficiary_relief = DB::table('beneficiary__reliefs')
      ->where('charities_id', $charityId)
      ->where('status', '!=', 'rejected')
      ->get();
  $beneficiaryIds = $beneficiary_relief->pluck('beneficiaries_id')->unique()->toArray();
  $beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');
  $reliefIds = $beneficiary_relief->pluck('reliefs_id')->unique()->toArray();
  $relief = DB::table('reliefs')->whereIn('id', $reliefIds)->get()->keyBy('id');
  $beneficiary_relief = $beneficiary_relief->map(function ($item) use ($beneficiaries, $relief) {
      $item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
      $item->relief = $relief[$item->reliefs_id] ?? null;
      return $item;
  });

  // Pagination
  $perPage = 10; // Assuming 10 items per page, adjust as needed
  $page = $request->get('page', 1); // Get the current page from the request, default to 1
  $offset = ($page - 1) * $perPage;

  $beneficiary_health_paginated = $beneficiary_health->slice($offset, $perPage)->values();
  $beneficiary_education_paginated = $beneficiary_education->slice($offset, $perPage)->values();
  $beneficiary_lifehood_paginated = $beneficiary_lifehood->slice($offset, $perPage)->values();
  $beneficiary_relief_paginated = $beneficiary_relief->slice($offset, $perPage)->values();

  // Fetch emergency orders
  $order = Orderesfromemergencystatus::where('charities_id', $charityId)->paginate($perPage);

  return response()->json([
      'status' => true,
      'message' => 'Get charity\'s orders',
      'data' => [
          'emergency_orders' => $order,
          'beneficiary_health' => $beneficiary_health_paginated->toArray(),
          'beneficiary_education' => $beneficiary_education_paginated->toArray(),
          'beneficiary_lifehood' => $beneficiary_lifehood_paginated->toArray(),
          'beneficiary_relief' => $beneficiary_relief_paginated->toArray(),
        //  'username' => $fullName,
      ],
      'pagination' => [
          'beneficiary_health' => [
              'current_page' => $page,
              'total_pages' => ceil($beneficiary_health->count() / $perPage),
              'total_items' => $beneficiary_health->count(),
              'items_per_page' => $perPage
          ],
          'beneficiary_education' => [
              'current_page' => $page,
              'total_pages' => ceil($beneficiary_education->count() / $perPage),
              'total_items' => $beneficiary_education->count(),
              'items_per_page' => $perPage
          ],
          'beneficiary_lifehood' => [
              'current_page' => $page,
              'total_pages' => ceil($beneficiary_lifehood->count() / $perPage),
              'total_items' => $beneficiary_lifehood->count(),
              'items_per_page' => $perPage
          ],
          'beneficiary_relief' => [
              'current_page' => $page,
              'total_pages' => ceil($beneficiary_relief->count() / $perPage),
              'total_items' => $beneficiary_relief->count(),
              'items_per_page' => $perPage
          ],
      ],
  ], 200);
}

public function indexordersaccepted(Request $request)
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



  $beneficiary_health = DB::table('beneficiary__healths')
    ->where('charities_id', $charityId)
    ->where('status', "approved")
    ->get();
// Load beneficiaries
$beneficiaryIds = $beneficiary_health->pluck('beneficiaries_id')->unique()->toArray();
$beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');
$beneficiaryUserIds = $beneficiaries->pluck('users_id')->unique()->toArray();

// Fetch users by their IDs, assuming 'User' is your User model
$users = User::whereIn('id', $beneficiaryUserIds)->get();

// Initialize variables to avoid undefined variable errors if no users are found
$firstName = '';
$lastName = '';

// Iterate through each user to get names
foreach ($users as $user) {
    $firstName = $user->firstName; // assuming 'firstName' is the attribute in your User model
    $lastName = $user->lastName;   // assuming 'lastName' is the attribute in your User model
}

// Concatenate first name and last name with a space in between
$fullName = $firstName . ' ' . $lastName;

// Load health
$healthIds = $beneficiary_health->pluck('healths_id')->unique()->toArray();
$health = DB::table('healths')->whereIn('id', $healthIds)->get()->keyBy('id');

// Merge results
$beneficiary_health = $beneficiary_health->map(function ($item) use ($beneficiaries, $health) {
  $item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
  $item->health = $health[$item->healths_id] ?? null;
  return $item;
});

///////////////////////////////////////////////////////////////
$beneficiary_education = DB::table('beneficiary__education')
->where('charities_id', $charityId)
->where('status',"approved")
->get();

// Load beneficiaries
$beneficiaryIds = $beneficiary_education->pluck('beneficiaries_id')->unique()->toArray();
$beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');

// Load health
$educationIds = $beneficiary_education->pluck('education_id')->unique()->toArray();
$education = DB::table('education')->whereIn('id', $educationIds)->get()->keyBy('id');

// Merge results
$beneficiary_education = $beneficiary_education->map(function ($item) use ($beneficiaries, $education) {
$item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
$item->education = $education[$item->education_id] ?? null;
return $item;
});
/////////////////////////////////////////////////////////////////////////////
$beneficiary_lifehood = DB::table('beneficiary__lifehoods')
->where('charities_id', $charityId)
->where('status', "approved")
->get();

// Load beneficiaries
$beneficiaryIds = $beneficiary_lifehood->pluck('beneficiaries_id')->unique()->toArray();
$beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');

// Load health
$lifehoodIds = $beneficiary_lifehood->pluck('lifehoods_id')->unique()->toArray();
$lifehood = DB::table('life_hoods')->whereIn('id', $lifehoodIds)->get()->keyBy('id');

// Merge results
$beneficiary_lifehood = $beneficiary_lifehood->map(function ($item) use ($beneficiaries, $lifehood) {
$item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
$item->lifehood = $lifehood[$item->lifehoods_id] ?? null;
return $item;
});
//////////////////////////////////////////////////////////////////////////
$beneficiary_relief = DB::table('beneficiary__reliefs')
->where('charities_id', $charityId)
->where('status', "approved")
->get();

// Load beneficiaries
$beneficiaryIds = $beneficiary_relief->pluck('beneficiaries_id')->unique()->toArray();
$beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');

// Load health
$reliefIds = $beneficiary_relief->pluck('reliefs_id')->unique()->toArray();
$relief = DB::table('reliefs')->whereIn('id', $reliefIds)->get()->keyBy('id');

// Merge results
$beneficiary_relief = $beneficiary_relief->map(function ($item) use ($beneficiaries, $relief) {
$item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
$item->relief = $relief[$item->reliefs_id] ?? null;
return $item;
});
///////////////////////////////////////////////////////////////////////
// Convert the collection to an array and return as JSON
/*return response()->json([
  'beneficiary_health' => $beneficiary_health->toArray(),
  'beneficiary_education' => $beneficiary_education->toArray(),
  'beneficiary_lifehood'=>$beneficiary_lifehood->toArray(),
  'beneficiary_relief'=>$beneficiary_relief->toArray()
]);*/
$perPage = 10; // Assuming 10 items per page, adjust as needed

$page = request()->get('page', 1); // Get the current page from the request, default to 1

$offset = ($page - 1) * $perPage;

$beneficiary_health_paginated = $beneficiary_health->slice($offset, $perPage);
$beneficiary_education_paginated = $beneficiary_education->slice($offset, $perPage);
$beneficiary_lifehood_paginated = $beneficiary_lifehood->slice($offset, $perPage);
$beneficiary_relief_paginated = $beneficiary_relief->slice($offset, $perPage);

return response()->json([
'status' => true,
'message' => 'Get charity\'s orders',
'data' => [
    'beneficiary_health' => $beneficiary_health_paginated->toArray(),
    'beneficiary_education' => $beneficiary_education_paginated->toArray(),
    'beneficiary_lifehood' => $beneficiary_lifehood_paginated->toArray(),
    'beneficiary_relief' => $beneficiary_relief_paginated->toArray(),
    'username'=>$fullName,
],
'pagination' => [
  'beneficiary_health'=>[
    'current_page' => $page,
    'total_pages' => ceil($beneficiary_health->count() / $perPage),
    'total_items' => $beneficiary_health->count(),
    'items_per_page' => $perPage],
    'beneficiary_education'=>[
      'current_page' => $page,
      'total_pages' => ceil($beneficiary_education->count() / $perPage),
      'total_items' => $beneficiary_education->count(),
      'items_per_page' => $perPage],
      'beneficiary_lifehood'=>[
        'current_page' => $page,
        'total_pages' => ceil($beneficiary_lifehood->count() / $perPage),
        'total_items' => $beneficiary_lifehood->count(),
        'items_per_page' => $perPage],
        'beneficiary_relief'=>[
          'current_page' => $page,
          'total_pages' => ceil($beneficiary_relief->count() / $perPage),
          'total_items' => $beneficiary_relief->count(),
          'items_per_page' => $perPage],

],
], 200);



}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexhealtsection(Request $request)
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




  $beneficiary_health = DB::table('beneficiary__healths')
      ->where('charities_id', null)
      ->where('status', "pending")
      ->where('status', '!=', 'rejected')
      ->get();

  // Load beneficiaries
/*  $beneficiaryIds = $beneficiary_health->pluck('beneficiaries_id')->unique()->toArray();
  $beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');
  $beneficiariesuser=  $beneficiaries->pluck('users_id')->unique()->toArray();
  $username=User::where('id',$beneficiariesuser)->get('name');
  dd(  $username);*/
  // This line is correct, assuming $beneficiary_health is a collection and 'beneficiaries_id' is the correct column name.
  $beneficiaryIds = $beneficiary_health->pluck('beneficiaries_id')->unique()->toArray();

  // Fetch beneficiaries from 'beneficiaries' table using their IDs
  $beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');

  // Extracting unique user IDs from the beneficiaries
  $beneficiaryUserIds = $beneficiaries->pluck('users_id')->unique()->toArray();

  // Fetch users by their IDs, assuming 'User' is your User model
  $users = User::whereIn('id', $beneficiaryUserIds)->get();

  // Initialize variables to avoid undefined variable errors if no users are found
  $firstName = '';
  $lastName = '';

  // Iterate through each user to get names
  foreach ($users as $user) {
      $firstName = $user->firstName; // assuming 'firstName' is the attribute in your User model
      $lastName = $user->lastName;   // assuming 'lastName' is the attribute in your User model
  }

  // Concatenate first name and last name with a space in between
  $fullName = $firstName . ' ' . $lastName;

  // Dump the full name


  // Load health
  $healthIds = $beneficiary_health->pluck('healths_id')->unique()->toArray();
  $health = DB::table('healths')->whereIn('id', $healthIds)->get()->keyBy('id');

  // Merge results
  $beneficiary_health = $beneficiary_health->map(function ($item) use ($beneficiaries, $health) {
      $item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
      $item->health = $health[$item->healths_id] ?? null;
      return $item;
  });
  $perPage = 10; // Assuming 10 items per page, adjust as needed

  $page = request()->get('page', 1); // Get the current page from the request, default to 1

  $offset = ($page - 1) * $perPage;

  $beneficiary_health_paginated = $beneficiary_health->slice($offset, $perPage);
  return response()->json([
  'status' => true,
  'message' => 'Get charity\'s orders',
'data'=>[
  'beneficiary_health' => $beneficiary_health_paginated->toArray()],
  'username'=>$fullName,
  'pagination' => [
      'current_page' => $page,
      'total_pages' => ceil($beneficiary_health->count() / $perPage),
      'total_items' => $beneficiary_health->count(),
      'items_per_page' => $perPage,

],
],200);
    }

    public function indexreliefsection(Request $request)
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


  $beneficiary_reliefs = DB::table('beneficiary__reliefs')
      ->where('charities_id', null)
      ->where('status', "pending")
      ->where('status', '!=', 'rejected')
      ->get();

  // Load beneficiaries
  $beneficiaryIds = $beneficiary_reliefs->pluck('beneficiaries_id')->unique()->toArray();
  $beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');
  $beneficiaryUserIds = $beneficiaries->pluck('users_id')->unique()->toArray();

  // Fetch users by their IDs, assuming 'User' is your User model
  $users = User::whereIn('id', $beneficiaryUserIds)->get();

  // Initialize variables to avoid undefined variable errors if no users are found
  $firstName = '';
  $lastName = '';

  // Iterate through each user to get names
  foreach ($users as $user) {
      $firstName = $user->firstName; // assuming 'firstName' is the attribute in your User model
      $lastName = $user->lastName;   // assuming 'lastName' is the attribute in your User model
  }

  // Concatenate first name and last name with a space in between
  $fullName = $firstName . ' ' . $lastName;


  // Load health
  $reliefIds = $beneficiary_reliefs->pluck('reliefs_id')->unique()->toArray();
  $relief = DB::table('reliefs')->whereIn('id', $reliefIds)->get()->keyBy('id');

  // Merge results
  $beneficiary_reliefs = $beneficiary_reliefs->map(function ($item) use ($beneficiaries, $relief) {
      $item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
      $item->relief = $relief[$item->reliefs_id] ?? null;
      return $item;
  });
  $perPage = 10; // Assuming 10 items per page, adjust as needed

  $page = request()->get('page', 1); // Get the current page from the request, default to 1

  $offset = ($page - 1) * $perPage;

  $beneficiary_relief_paginated = $beneficiary_reliefs->slice($offset, $perPage);
  return response()->json([
  'status' => true,
  'message' => 'Get charity\'s orders',
'data'=>[
  'beneficiary_relief' => $beneficiary_relief_paginated->toArray()],
  'username'=>$fullName,
  'pagination' => [
      'current_page' => $page,
      'total_pages' => ceil($beneficiary_reliefs->count() / $perPage),
      'total_items' => $beneficiary_reliefs->count(),
      'items_per_page' => $perPage,

],
],200);
    }


    public function indexeducationsection(Request $request)
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


    $beneficiary_education = DB::table('beneficiary__education')
      ->where('charities_id', null)
      ->where('status', "pending")
      ->where('status', '!=', 'rejected')
      ->get();

    // Load beneficiaries
    $beneficiaryIds = $beneficiary_education->pluck('beneficiaries_id')->unique()->toArray();
    $beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');
    $beneficiaryUserIds = $beneficiaries->pluck('users_id')->unique()->toArray();

    // Fetch users by their IDs, assuming 'User' is your User model
    $users = User::whereIn('id', $beneficiaryUserIds)->get();

    // Initialize variables to avoid undefined variable errors if no users are found
    $firstName = '';
    $lastName = '';

    // Iterate through each user to get names
    foreach ($users as $user) {
        $firstName = $user->firstName; // assuming 'firstName' is the attribute in your User model
        $lastName = $user->lastName;   // assuming 'lastName' is the attribute in your User model
    }

    // Concatenate first name and last name with a space in between
    $fullName = $firstName . ' ' . $lastName;

    // Load health
    $educationIds = $beneficiary_education->pluck('education_id')->unique()->toArray();
    $education = DB::table('education')->whereIn('id', $educationIds)->get()->keyBy('id');

    // Merge results
    $beneficiary_education = $beneficiary_education->map(function ($item) use ($beneficiaries, $education) {
      $item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
      $item->education = $education[$item->education_id] ?? null;
      return $item;
    });
    $perPage = 10; // Assuming 10 items per page, adjust as needed

    $page = request()->get('page', 1); // Get the current page from the request, default to 1

    $offset = ($page - 1) * $perPage;

    $beneficiary_education_paginated = $beneficiary_education->slice($offset, $perPage);
    return response()->json([
    'status' => true,
    'message' => 'Get charity\'s orders',
    'data'=>[
    'beneficiary_education' => $beneficiary_education_paginated->toArray()],
    'username'=>$fullName,
    'pagination' => [
      'current_page' => $page,
      'total_pages' => ceil($beneficiary_education->count() / $perPage),
      'total_items' => $beneficiary_education->count(),
      'items_per_page' => $perPage,

    ],
    ],200);
    }


    public function indexlifehoodsection(Request $request)
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


    $beneficiary_lifehood = DB::table('beneficiary__lifehoods')
      ->where('charities_id', null)
      ->where('status', "pending")
      ->where('status', '!=', 'rejected')
      ->get();

    // Load beneficiaries
    $beneficiaryIds = $beneficiary_lifehood->pluck('beneficiaries_id')->unique()->toArray();
    $beneficiaries = DB::table('beneficiaries')->whereIn('id', $beneficiaryIds)->get()->keyBy('id');
    $beneficiaryUserIds = $beneficiaries->pluck('users_id')->unique()->toArray();

    // Fetch users by their IDs, assuming 'User' is your User model
    $users = User::whereIn('id', $beneficiaryUserIds)->get();

    // Initialize variables to avoid undefined variable errors if no users are found
    $firstName = '';
    $lastName = '';

    // Iterate through each user to get names
    foreach ($users as $user) {
        $firstName = $user->firstName; // assuming 'firstName' is the attribute in your User model
        $lastName = $user->lastName;   // assuming 'lastName' is the attribute in your User model
    }

    // Concatenate first name and last name with a space in between
    $fullName = $firstName . ' ' . $lastName;

    // Load health
    $lifehoodIds = $beneficiary_lifehood->pluck('lifehoods_id')->unique()->toArray();
    $lifehood = DB::table('life_hoods')->whereIn('id', $lifehoodIds)->get()->keyBy('id');

    // Merge results
    $beneficiary_lifehood = $beneficiary_lifehood->map(function ($item) use ($beneficiaries, $lifehood) {
      $item->beneficiaries = $beneficiaries[$item->beneficiaries_id] ?? null;
      $item->lifehood = $lifehood[$item->lifehoods_id] ?? null;
      return $item;
    });
    $perPage = 10; // Assuming 10 items per page, adjust as needed

    $page = request()->get('page', 1); // Get the current page from the request, default to 1

    $offset = ($page - 1) * $perPage;

    $beneficiary_lifehood_paginated = $beneficiary_lifehood->slice($offset, $perPage);
    return response()->json([
    'status' => true,
    'message' => 'Get charity\'s orders',
    'data'=>[
    'beneficiary_lifehood' => $beneficiary_lifehood_paginated->toArray()],
    'username'=>$fullName,
    'pagination' => [
      'current_page' => $page,
      'total_pages' => ceil($beneficiary_lifehood->count() / $perPage),
      'total_items' => $beneficiary_lifehood->count(),
      'items_per_page' => $perPage,

    ],
    ],200);
    }

    ////////////////////////////////////////////////
    public function showDetailsOrder(Request $request, $id) {
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
        return response()->json([ 'status' => false, 'message' => 'Unauthorized'], 401);
    }

    // Validate that the token matches the latest token
    if ($charity->latest_token !== $hashedToken) {
        return response()->json([ 'status' => false, 'message' => 'Unauthorized: Invalid token'], 401);
    }

    // Check if the token has the required capability
    if (!$charity->tokenCan('Charity Access Token')) {
        return response()->json([ 'status' => false, 'message' => 'Unauthorized: Token does not have the required capability.'], 403);
    }

    $charityId = $charity->id;

    try {
        // Fetch the beneficiary with the corresponding details
        $beneficiary = Beneficiary::findOrFail($id);
        $beneficiaryId = $beneficiary->id;
        $beneficiaryUserIds = [$beneficiary->users_id]; // Assuming users_id is a single value, not a collection

        // Fetch users by their IDs, assuming 'User' is your User model
        $users = User::whereIn('id', $beneficiaryUserIds)->get();

        // Initialize variables to avoid undefined variable errors if no users are found
        $fullName = '';

        // Iterate through each user to get names
        foreach ($users as $user) {
            $fullName = $user->firstName . ' ' . $user->lastName; // assuming 'firstName' and 'lastName' are attributes in your User model
        }

        // Fetch all records without pagination
        $healths = Beneficiary_Health::where('beneficiaries_id', $beneficiaryId)->with('healths')->get();
        $educations = Beneficiary_Education::where('beneficiaries_id', $beneficiaryId)->with('education')->get();
        $reliefs = Beneficiary_Relief::where('beneficiaries_id', $beneficiaryId)->with('relief')->get();
        $lifehoods = Beneficiary_Lifehood::where('beneficiaries_id', $beneficiaryId)->with('life_hoods')->get();

        // Initialize caseform variables
        $caseforms = [];
        $caseformHealths = [];
        $caseformEducations = [];
        $caseformReliefs = [];
        $caseformLifehoods = [];
        $caseformMids = [];

        // Check for case form health
        if ($healths != null) {
            $assignOrders = assign_orders_volunteer::where('beneficiaries_id', $id)->pluck('id');
            $caseformHealthMids = caseform_health_mid::whereIn('assign_id', $assignOrders)->get();

            foreach ($caseformHealthMids as $caseformHealthMid) {
                $caseform = caseforms::where('id', $caseformHealthMid->caseforms_id)->first();
                $caseformHealth = caseform_health::where('id', $caseformHealthMid->caseformhealths_id)->first();
                $caseforms[] = $caseform;
                $caseformHealths[] = $caseformHealth;
                $caseformMids[] = $caseformHealthMid;
            }
        }

        // Check for case form education
        if ($educations != null) {
            $assignOrders = assign_orders_volunteer::where('beneficiaries_id', $id)->pluck('id');
            $caseformEducationMids = caseform_education_mid::whereIn('assign_id', $assignOrders)->get();

            foreach ($caseformEducationMids as $caseformEducationMid) {
                $caseform = caseforms::where('id', $caseformEducationMid->caseforms_id)->first();
                $caseformEducation = caseform_education::where('id', $caseformEducationMid->caseformeducations_id)->first();
                $caseforms[] = $caseform;
                $caseformEducations[] = $caseformEducation;
                $caseformMids[] = $caseformEducationMid;
            }
        }

        // Check for case form relief
        if ($reliefs != null) {
            $assignOrders = assign_orders_volunteer::where('beneficiaries_id', $id)->pluck('id');
            $caseformReliefMids = caseform_relief_mid::whereIn('assign_id', $assignOrders)->get();

            foreach ($caseformReliefMids as $caseformReliefMid) {
                $caseform = caseforms::where('id', $caseformReliefMid->caseforms_id)->first();
                $caseformRelief = caseform_reliefs::where('id', $caseformReliefMid->caseformreliefs_id)->first();
                $caseforms[] = $caseform;
                $caseformReliefs[] = $caseformRelief;
                $caseformMids[] = $caseformReliefMid;
            }
        }

        // Check for case form lifehood
        if ($lifehoods != null) {
            $assignOrders = assign_orders_volunteer::where('beneficiaries_id', $id)->pluck('id');
            $caseformLifehoodMids = caseform_lifehood_mid::whereIn('assign_id', $assignOrders)->get();

            foreach ($caseformLifehoodMids as $caseformLifehoodMid) {
                $caseform = caseforms::where('id', $caseformLifehoodMid->caseforms_id)->first();
                $caseformLifehood = caseform_lifehoods::where('id', $caseformLifehoodMid->caseformlifehoods_id)->first();
                $caseforms[] = $caseform;
                $caseformLifehoods[] = $caseformLifehood;
                $caseformMids[] = $caseformLifehoodMid;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Details fetched successfully for beneficiary ID: ' . $beneficiaryId,
            'data' => [
                'beneficiary' => $beneficiary,
                'healths' => $healths,
                'educations' => $educations,
                'reliefs' => $reliefs,
                'lifehoods' => $lifehoods,
                'username' => $fullName,
                'caseforms' => $caseforms,
                'caseformHealths' => $caseformHealths,
                'caseformEducations' => $caseformEducations,
                'caseformReliefs' => $caseformReliefs,
                'caseformLifehoods' => $caseformLifehoods,
                'caseformMids' => $caseformMids,
                'pagination'=>[],
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([ 'status' => false, 'message' => 'Error processing your request: ' . $e->getMessage()], 500);
    }
}



///////////////////////////////////////////////////////////////////
  public function register(Request $request)
  {
      try {
          // Validate the request data
          $validator = Validator::make($request->all(), [
              'name' => 'required|string|max:255',
              'email' => 'required|email|unique:charities,email',
              'password' => 'required|string|min:8',
              'description' => 'required|string',
              'address' => 'required|string|max:255',
              'nameoftheheadofcharity' => 'required|string|max:255',
              'vicepresidentofcharity' => 'required|string|max:255',
              'typeofcharity' => 'required|string|max:255',
              'nameofcashier' => 'required|string|max:255',
              'numberbankaccount' => 'required|string|max:255',
              'licensenumber' => 'required|string|max:255',
              'numberofvolunteer' => 'required|integer',
              'charityphone' => 'required|string|max:15',
              'whatsappnumber' => 'required|string|max:15',
              'linkoffacebookpage' => 'required|url',
              'linkwebsite' => 'required|url',
              'governorate' => 'required|string|max:255',
              'district' => 'required|string|max:255',
              'sub_district' => 'required|string|max:255',
              'community' => 'required|string|max:255',
              'street' => 'required|string|max:255',
              'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          ]);

          if ($validator->fails()) {
              return response()->json([
                  'status' => false,
                  'message' => 'Validation error',
                  'errors' => $validator->errors()
              ], 422);
          }

          // Handle the image upload

        /*  // Create the charity data array
          $charityData = [
              'name' => $request->name,
              'email' => $request->email,
              'password' => Hash::make($request->password),
              'address' => $request->address,
              'nameoftheheadofcharity' => $request->nameoftheheadofcharity,
              'vicepresidentofcharity' => $request->vicepresidentofcharity,
              'typeofcharity' => $request->typeofcharity,
              'nameofcashier' => $request->nameofcashier,
              'numberbankaccount' => $request->numberbankaccount,
              'licensenumber' => $request->licensenumber,
              'numberofvolunteer' => $request->numberofvolunteer,
              'linkwebsite' => $request->linkwebsite,
              'charityphone' => $request->charityphone,
              'whatsappnumber' => $request->whatsappnumber,
              'linkoffacebookpage' => $request->linkoffacebookpage,
              'description' => $request->description,
              'image' => $imagePath,
              'created_at' => now(),
              'updated_at' => now(),
          ];*/


          // Insert the charity data and get the inserted record's ID
          $charity = Charity::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'nameoftheheadofcharity' => $request->nameoftheheadofcharity,
            'vicepresidentofcharity' => $request->vicepresidentofcharity,
            'typeofcharity' => $request->typeofcharity,
            'nameofcashier' => $request->nameofcashier,
            'numberbankaccount' => $request->numberbankaccount,
            'licensenumber' => $request->licensenumber,
            'numberofvolunteer' => $request->numberofvolunteer,
            'linkwebsite' => $request->linkwebsite,
            'charityphone' => $request->charityphone,
            'whatsappnumber' => $request->whatsappnumber,
            'linkoffacebookpage' => $request->linkoffacebookpage,
            'description' => $request->description,
          //  'image' => $imagePath,
            'created_at' => now(),
            'updated_at' => now(),
          ]);

          // Retrieve the newly inserted record as a model instance
        //  $charity = Charity::find($charityId);

        if ($request->hasFile('image')) {
           $imagePath = $request->file('image')->store('public/charity_images'); // Store image
           $imagePath = Storage::url($imagePath); // Get URL to saved image
            $charity->image=$imagePath;
              $charity->save();
        }
      else{
          $charity->image=null;
      }
          $location = LocationThatCoveredByCharities::create([
              'governorate' => $request->governorate,
              'district' => $request->district,
              'sub_district' => $request->sub_district,
              'community' => $request->community,
              'street' => $request->street,
              'charities_id' => $charity->id,
          ]);

          // Create an API token for the charity
          $token = $charity->createToken('Charity Access Token')->plainTextToken;

          // Store the latest token hash
          $charity->latest_token = hash('sha256', $token);
          $charity->save();

          // Prepare the response data
          $charityDataResponse = [
              'token' => $token,
              'charity' => $charity
          ];

  // Paginate the charities
          $charities = Charity::paginate(10); // Adjust the pagination as needed
          // Get effectiveness count
          $effectiveness = Effectiveness::where('charities_id', $charity->id)->count();
          return response()->json([
              'status' => true,
              'message' => 'Charity Created Successfully',
              'data' => [
                  'charity' => $charityDataResponse,
                  'location' => $location,
                  'effectiveness' => $effectiveness,
              ],
              'pagination' => [
                  'current_page' => $charities->currentPage(),
                  'total_pages' => $charities->lastPage(),
                  'total_items' => $charities->total(),
                  'items_per_page' => $charities->perPage(),
                  'first_item' => $charities->firstItem(),
                  'last_item' => $charities->lastItem(),
                  'has_more_pages' => $charities->hasMorePages(),
                  'next_page_url' => $charities->nextPageUrl(),
                  'previous_page_url' => $charities->previousPageUrl(),
              ],
          ], 200);
      } catch (\Throwable $th) {
          return response()->json([
              'status' => false,
              'message' => $th->getMessage()
          ], 500);
      }
  }
/*
public function login(Request $request)
{
    // Validate request data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Find charity by email, case-insensitive
    $charity = Charity::whereRaw('lower(email) = ?', [strtolower($request->email)])->first();

    // Check if charity exists and password is correct
    if ($charity && Hash::check($request->password, $charity->password)) {
        // Create token
        $token = $charity->createToken('Charity Access Token')->plainTextToken;
        // Store the latest token hash
        $charity->latest_token = hash('sha256', $token);
        $charity->save();
        // Get paginated charities
        $charities = Charity::paginate(10); // Adjust pagination as needed

        // Prepare response data
        $data = [
            'token' => $token,
            'charity' => $charity,
        ];

        // Prepare pagination data
        $pagination = [
            'current_page' => $charities->currentPage(),
            'total_pages' => $charities->lastPage(),
            'total_items' => $charities->total(),
            'items_per_page' => $charities->perPage(),
            'first_item' => $charities->firstItem(),
            'last_item' => $charities->lastItem(),
            'has_more_pages' => $charities->hasMorePages(),
            'next_page_url' => $charities->nextPageUrl(),
            'previous_page_url' => $charities->previousPageUrl(),
        ];

        // Return success response with data and pagination
        return response()->json([
            'status' => true,
            'message' => 'Charity logged in successfully',
            'data' => $data,
            'pagination' => $pagination,
        ], 200);
    }

    // Return error response if credentials do not match
    return response()->json(['error' => 'The provided credentials do not match our records.'], 401);
}
*/
public function login(Request $request)
{
    try {
        // Validate request data
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find charity by email, case-sensitive
        $charity = Charity::where('email', $request->email)->first();

        // Check if charity exists
        if (!$charity) {
            return response()->json(['status' => false, 'message' => 'The provided email does not match our records.'], 400);
        }

        // Check if password is correct
        if (!Hash::check($request->password, $charity->password)) {
            return response()->json(['status' => false, 'message' => 'The provided password is incorrect.'], 400);
        }

        // Create token
        $token = $charity->createToken('Charity Access Token')->plainTextToken;

        // Store the latest token hash
        $charity->latest_token = hash('sha256', $token);
        $charity->save();

        // Get effectiveness count
        $effectiveness = Effectiveness::where('charities_id', $charity->id)->count();
$charity->effectiveness = $effectiveness;
        // Prepare response data
        $data = [
            'token' => $token,
            'charity' => $charity,
          //  'effectiveness' => $effectiveness,
        ];

        // Return success response with data
        return response()->json([
            'status' => true,
            'message' => 'Charity logged in successfully',
            'data' => $data,
        ], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        // Handle unexpected errors
        return response()->json(['status' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()], 500);
    }
}
public function logout(Request $request)
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

    // Retrieve the authenticated user
    $charity = Auth::guard('api-charities')->user();

    // Check if user is authenticated
    if (!$charity) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized',
        ], 401);
    }

    // Revoke the token
    $charity->currentAccessToken()->delete();

    return response()->json([
        'status' => true,
        'message' => 'Successfully logged out',
    ], 200);
}


public function search(Request $request)
   {
       $term = $request->input('term');

       // If no term provided, you might want to return all users or a specific message
       if (empty($term)) {
           return response()->json(['message' => 'No search term provided'], 400);
       }

       $users = User::search($term)->get();

       return response()->json([
           'status' => true,
           'message' => 'Search results',
           'data' => $users
       ], 200);
   }



   public function acceptvolunteerorders($volunteerOrderId, Request $request)
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
               return response()->json([   'status' => false,'message' => 'Unauthorized'], 401);
           }

           // Validate that the token matches the latest token
           if ($charity->latest_token !== $hashedToken) {
               return response()->json([   'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
           }

           // Check if the token has the required capability
           if (!$charity->tokenCan('Charity Access Token')) {
               return response()->json([   'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
           }

           // Retrieve the volunteer order
           $volunteerOrder = Volunteer::where('id', $volunteerOrderId)->first();

           if (!$volunteerOrder) {
               return response()->json([
                   'status' => false,
                   'message' => 'Volunteer order not found.',
               ], 404);
           }

           // Update the status to "accept"
           $volunteerOrder->status = 'accept';
           $volunteerOrder->save();

           return response()->json([
               'status' => true,
               'message' => 'Charity accepted volunteer order',
               'data' => $volunteerOrder,
               'pagination' => [
                   'current_page' => 1,
                   'total_pages' => 1,
                   'total_items' => 1,
                   'items_per_page' => 1,
               ],
           ], 200);
       }



       public function rejectvolunteerorders($volunteerOrderId, Request $request)
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
                   return response()->json([   'status' => false,'message' => 'Unauthorized'], 401);
               }

               // Validate that the token matches the latest token
               if ($charity->latest_token !== $hashedToken) {
                   return response()->json([   'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
               }

               // Check if the token has the required capability
               if (!$charity->tokenCan('Charity Access Token')) {
                   return response()->json([   'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
               }

               // Retrieve the volunteer order
               $volunteerOrder = Volunteer::where('id', $volunteerOrderId)->first();

               if (!$volunteerOrder) {
                   return response()->json([
                       'status' => false,
                       'message' => 'Volunteer order not found.',
                   ], 404);
               }


               $volunteerOrder->status = 'reject';
               $volunteerOrder->save();

               return response()->json([
                   'status' => true,
                   'message' => 'Charity rejected volunteer order',
                   'data' => $volunteerOrder,
                   'pagination' => [
                       'current_page' => 1,
                       'total_pages' => 1,
                       'total_items' => 1,
                       'items_per_page' => 1,
                   ],
               ], 200);
           }



           public function indexvolunteerorders(Request $request)
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
              return response()->json([  'status' => false,
                'message' => 'Unauthorized'], 401);
          }

          // Validate that the token matches the latest token
          if ($charity->latest_token !== $hashedToken) {
              return response()->json([  'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
          }

          // Check if the token has the required capability
          if (!$charity->tokenCan('Charity Access Token')) {
              return response()->json([  'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
          }

          $charityId = $charity->id;

          // Retrieve the volunteer orders
          $volunteerOrders = Volunteer::where('charities_id', $charityId)
          ->where('status','waiting')
          ->paginate(10);

          return response()->json([
              'status' => true,
              'message' => 'Index Charity volunteer orders',
              'data' => $volunteerOrders->items(),
              'pagination' => [
                  'current_page' => $volunteerOrders->currentPage(),
                  'total_pages' => $volunteerOrders->lastPage(),
                  'total_items' => $volunteerOrders->total(),
                  'items_per_page' => $volunteerOrders->perPage(),
                  'first_item' => $volunteerOrders->firstItem(),
                  'last_item' => $volunteerOrders->lastItem(),
                  'has_more_pages' => $volunteerOrders->hasMorePages(),
                  'next_page_url' => $volunteerOrders->nextPageUrl(),
                  'previous_page_url' => $volunteerOrders->previousPageUrl(),
              ],
          ], 200);
      }


      public function detailsvolunteerorders(Request $request,$volunteerorderId)
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

     $charityId = $charity->id;

     // Retrieve the volunteer orders
     $volunteerOrders = Volunteer::where('id', $volunteerorderId)->paginate(10);

     return response()->json([
         'status' => true,
         'message' => 'Index Charity volunteer orders',
         'data' => $volunteerOrders->items(),
         'pagination' => [
             'current_page' => $volunteerOrders->currentPage(),
             'total_pages' => $volunteerOrders->lastPage(),
             'total_items' => $volunteerOrders->total(),
             'items_per_page' => $volunteerOrders->perPage(),
             'first_item' => $volunteerOrders->firstItem(),
             'last_item' => $volunteerOrders->lastItem(),
             'has_more_pages' => $volunteerOrders->hasMorePages(),
             'next_page_url' => $volunteerOrders->nextPageUrl(),
             'previous_page_url' => $volunteerOrders->previousPageUrl(),
         ],
     ], 200);
   }



   // public function getCaseformsByCharity(Request $request)
   //    {
   //        $token = $request->header('Authorization');
   //        if (!$token) {
   //            return response()->json([
   //                'status' => false,
   //                'message' => 'Authorization token not provided.',
   //            ], 401);
   //        }
   //
   //        // Remove 'Bearer ' from the token string
   //        $token = str_replace('Bearer ', '', $token);
   //        $hashedToken = hash('sha256', $token);
   //
   //        // Retrieve the authenticated user
   //        $charity = Auth::guard('api-charities')->user();
   //
   //        // Check if user is authenticated
   //        if (!$charity) {
   //            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
   //        }
   //
   //        // Validate that the token matches the latest token
   //        if ($charity->latest_token !== $hashedToken) {
   //            return response()->json(['status' => false, 'message' => 'Unauthorized: Invalid token'], 401);
   //        }
   //
   //        // Check if the token has the required capability
   //        if (!$charity->tokenCan('Charity Access Token')) {
   //            return response()->json(['status' => false, 'message' => 'Unauthorized: Token does not have the required capability.'], 403);
   //        }
   //
   //        $charityId = $charity->id;
   //
   //        $perPage = $request->input('per_page', 10); // Number of items per page, default to 10
   //        $page = $request->input('page', 1); // Current page number, default to 1
   //
   //        $query = caseforms::whereHas('caseformHealthMids.assignOrdersVolunteer', function ($query) use ($charityId) {
   //            $query->where('charities_id', $charityId);
   //        })->orWhereHas('caseformEducationMids.assignOrdersVolunteer', function ($query) use ($charityId) {
   //            $query->where('charities_id', $charityId);
   //        })->orWhereHas('caseformReliefMids.assignOrdersVolunteer', function ($query) use ($charityId) {
   //            $query->where('charities_id', $charityId);
   //        })->orWhereHas('caseformLifehoodMids.assignOrdersVolunteer', function ($query) use ($charityId) {
   //            $query->where('charities_id', $charityId);
   //        });
   //
   //        $caseforms = $query->paginate($perPage, ['*'], 'page', $page);
   //
   //        if ($caseforms->isEmpty()) {
   //            return response()->json(['status' => true, 'message' => 'No case forms found for this charity.', 'data' => [], 'pagination' => []], 404);
   //        }
   //
   //        $caseforms->load([
   //            'caseformHealthMids.caseformHealth',
   //            'caseformEducationMids.caseformEducation',
   //            'caseformReliefMids.caseformRelief',
   //            'caseformLifehoodMids.caseformLifehood'
   //        ]);
   //
   //        return response()->json([
   //            'status' => true,
   //            'message' => 'Case forms retrieved successfully.',
   //            'data' => $caseforms->items(),
   //            'pagination' => [
   //                'current_page' => $caseforms->currentPage(),
   //                'total_pages' => $caseforms->lastPage(),
   //                'total_items' => $caseforms->total(),
   //                'items_per_page' => $caseforms->perPage(),
   //                'first_item' => $caseforms->firstItem(),
   //                'last_item' => $caseforms->lastItem(),
   //                'has_more_pages' => $caseforms->hasMorePages(),
   //                'next_page_url' => $caseforms->nextPageUrl(),
   //                'previous_page_url' => $caseforms->previousPageUrl(),
   //            ],
   //        ], 200);
   //    }



   public function getCaseformsByCharity(Request $request)
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
             return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
         }

         // Validate that the token matches the latest token
         if ($charity->latest_token !== $hashedToken) {
             return response()->json(['status' => false, 'message' => 'Unauthorized: Invalid token'], 401);
         }

         // Check if the token has the required capability
         if (!$charity->tokenCan('Charity Access Token')) {
             return response()->json(['status' => false, 'message' => 'Unauthorized: Token does not have the required capability.'], 403);
         }

         $charityId = $charity->id;

         $perPage = $request->input('per_page', 10); // Number of items per page, default to 10
         $page = $request->input('page', 1); // Current page number, default to 1

         $query = caseforms::whereHas('caseformHealthMids.assignOrdersVolunteer', function ($query) use ($charityId) {
             $query->where('charities_id', $charityId);
         })->orWhereHas('caseformEducationMids.assignOrdersVolunteer', function ($query) use ($charityId) {
             $query->where('charities_id', $charityId);
         })->orWhereHas('caseformReliefMids.assignOrdersVolunteer', function ($query) use ($charityId) {
             $query->where('charities_id', $charityId);
         })->orWhereHas('caseformLifehoodMids.assignOrdersVolunteer', function ($query) use ($charityId) {
             $query->where('charities_id', $charityId);
         });

         $caseforms = $query->paginate($perPage, ['*'], 'page', $page);

         if ($caseforms->isEmpty()) {
             return response()->json(['status' => true, 'message' => 'No case forms found for this charity.', 'data' => [], 'pagination' => []], 404);
         }

         $caseforms->load([
             'caseformHealthMids.assignOrdersVolunteer.beneficiary',
             'caseformEducationMids.assignOrdersVolunteer.beneficiary',
             'caseformReliefMids.assignOrdersVolunteer.beneficiary',
             'caseformLifehoodMids.assignOrdersVolunteer.beneficiary'
         ]);

         // Prepare the data to include the beneficiary information
         $data = $caseforms->map(function ($caseform) {
             return [
                 'caseform' => $caseform,
                 'caseform_health_mids' => $caseform->caseformHealthMids->map(function ($mid) {
                     return [
                         'mid' => $mid,
                         'beneficiary' => $mid->assignOrdersVolunteer->beneficiary,
                     ];
                 }),
                 'caseform_education_mids' => $caseform->caseformEducationMids->map(function ($mid) {
                     return [
                         'mid' => $mid,
                         'beneficiary' => $mid->assignOrdersVolunteer->beneficiary,
                     ];
                 }),
                 'caseform_relief_mids' => $caseform->caseformReliefMids->map(function ($mid) {
                     return [
                         'mid' => $mid,
                         'beneficiary' => $mid->assignOrdersVolunteer->beneficiary,
                     ];
                 }),
                 'caseform_lifehood_mids' => $caseform->caseformLifehoodMids->map(function ($mid) {
                     return [
                         'mid' => $mid,
                         'beneficiary' => $mid->assignOrdersVolunteer->beneficiary,
                     ];
                 }),
             ];
         });

         return response()->json([
             'status' => true,
             'message' => 'Case forms retrieved successfully.',
             'data' => $data,
             'pagination' => [
                 'current_page' => $caseforms->currentPage(),
                 'total_pages' => $caseforms->lastPage(),
                 'total_items' => $caseforms->total(),
                 'items_per_page' => $caseforms->perPage(),
                 'first_item' => $caseforms->firstItem(),
                 'last_item' => $caseforms->lastItem(),
                 'has_more_pages' => $caseforms->hasMorePages(),
                 'next_page_url' => $caseforms->nextPageUrl(),
                 'previous_page_url' => $caseforms->previousPageUrl(),
             ],
         ], 200);
     }
}
