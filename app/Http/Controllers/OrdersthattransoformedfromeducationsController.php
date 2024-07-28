<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Ordersthattransoformedfromeducations;
use App\Models\Beneficiary_Health;
use App\Models\Beneficiary_Relief;
use App\Models\Beneficiary_Education;
use App\Models\Beneficiary_Lifehood;
use Illuminate\Http\Request;
  use Illuminate\Support\Facades\DB;
  //use App\Models\Beneficiary_Education;
class OrdersthattransoformedfromeducationsController extends Controller
{
  public function transformEducation(Request $request, $id)
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
        return response()->json([    'status' => false,'message' => 'Unauthorized'], 401);
    }

    // Validate that the token matches the latest token
    if ($charity->latest_token !== $hashedToken) {
        return response()->json([    'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
    }

    // Check if the token has the required capability
    if (!$charity->tokenCan('Charity Access Token')) {
        return response()->json([    'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
    }

    // Get the user ID
    $charityId = $charity->id;

      // Get the beneficiary education records associated with the beneficiary ID
      $beneficiaries_educations = Beneficiary_Education::where('beneficiaries_id', $id)->get();

      // Check if there are any beneficiary education records
      if ($beneficiaries_educations->isEmpty()) {
          return response()->json([    'status' => false,'message' => 'Beneficiary education not found'], 404);
      }

      // Set charities_id to null for each Beneficiary_Education entry
      foreach ($beneficiaries_educations as $education) {
        if($education->charities_id == null){
            return response()->json([    'status' => false,'message' => 'Beneficiary education is already in the education section'], 404);
        }else{
          $education->charities_id = null;
          $education->save();
        }

      }

      // Insert the transformed order with the first beneficiary education ID
      $beneficiaries_education_id = $beneficiaries_educations->first()->id;



      $data = [
      'charities_id' => $charityId,
      'beneficiaries__educations_id' => $beneficiaries_education_id,
      'reasonoftransformed' => $request->reasonoftransformed,
  ];

  // Insert the data and get the ID of the newly inserted record
  $insertedId = DB::table('orderstransededucations')->insertGetId($data);

  // Retrieve the inserted record
  $insertedData = DB::table('orderstransededucations')->where('id', $insertedId)->first();


      return response()->json([
            'status' => true,
          'message' => 'Order transformed successfully',
          'data' =>[ $beneficiaries_educations,'data'=>$insertedData],
          'pagination' => [
              'current_page' => 1,
              'total_pages' => 1,
              'total_items' => 1,
              'items_per_page' => 1,
          ],
      ], 201);
  }


  public function transform(Request $request, $id)
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
        return response()->json([    'status' => false,'message' => 'Unauthorized'], 401);
    }

    // Validate that the token matches the latest token
    if ($charity->latest_token !== $hashedToken) {
        return response()->json([    'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
    }

    // Check if the token has the required capability
    if (!$charity->tokenCan('Charity Access Token')) {
        return response()->json([    'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
    }

    // Get the user ID
    $charityId = $charity->id;

    switch ($request->type) {
        case 'education':
            $beneficiaries = Beneficiary_Education::where('beneficiaries_id', $id)->get();
            $table = 'orderstransededucations';
            $foreignKey = 'beneficiaries__educations_id';
            $modelClass = Beneficiary_Education::class;
            break;

        case 'health':
            $beneficiaries = Beneficiary_Health::where('beneficiaries_id', $id)->get();
            $table = 'orderstransoformedhealths';
            $foreignKey = 'beneficiaries__healths_id';
            $modelClass = Beneficiary_Health::class;
            break;

        case 'lifehood':
            $beneficiaries = Beneficiary_Lifehood::where('beneficiaries_id', $id)->get();
            $table = 'ordertransoformedlifehoods';
            $foreignKey = 'beneflifehoods_id';
            $modelClass = Beneficiary_Lifehood::class;
            break;

        case 'relief':
            $beneficiaries = Beneficiary_Relief::where('beneficiaries_id', $id)->get();
            $table = 'orderstransoformedreliefs';
            $foreignKey = 'beneficiaries__reliefs_id';
            $modelClass = Beneficiary_Relief::class;
            break;

        default:
            return response()->json(['message' => 'Invalid transformation type'], 400);
    }

    // Check if there are any beneficiary records
    if ($beneficiaries->isEmpty()) {
        return response()->json([    'status' => false,'message' => 'Beneficiary not found'], 404);
    }

    // Set charities_id to null for each Beneficiary entry
    foreach ($beneficiaries as $beneficiary) {
        if ($beneficiary->charities_id == null) {
            return response()->json([    'status' => false,'message' => 'Beneficiary is already in the section ' . $request->ype . ' section'], 404);
        } else {
            $beneficiary->charities_id = null;
            $beneficiary->save();
        }
    }

    // Insert the transformed order with the first beneficiary ID
    $beneficiaryId = $beneficiaries->first()->id;

    $data = [
        'charities_id' => $charityId,
        $foreignKey => $beneficiaryId,
        'reasonoftransformed' => $request->reasonoftransformed,
    ];

    // Insert the data and get the ID of the newly inserted record
    $insertedId = DB::table($table)->insertGetId($data);

    // Retrieve the inserted record
    $insertedData = DB::table($table)->where('id', $insertedId)->first();

    return response()->json([
      'status'=>true,
        'message' => 'Order transformed successfully',
        'data' => [
            $beneficiaries,
            $insertedData
        ],
        'pagination' => [
            'current_page' => 1,
            'total_pages' => 1,
            'total_items' => 1,
            'items_per_page' => 1,
        ],
    ], 201);
}

  }
