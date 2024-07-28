<?php

namespace App\Http\Controllers;

use App\Models\Ordersthattransoformedfromreliefs;
use Auth;
use Illuminate\Http\Request;
  use Illuminate\Support\Facades\DB;
use App\Models\Beneficiary_Relief;
class OrdersthattransoformedfromreliefsController extends Controller
{

  public function transformrelief(Request $request, $id)
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
    $beneficiaries_reliefs = Beneficiary_Relief::where('beneficiaries_id', $id)->get();

    // Check if there are any beneficiary education records
    if ($beneficiaries_reliefs->isEmpty()) {
        return response()->json([    'status' => false,'message' => 'Beneficiary relief not found'], 404);
    }

    // Set charities_id to null for each Beneficiary_Education entry
    foreach ($beneficiaries_reliefs as $lifehood) {
      if($lifehood->charities_id == null){
          return response()->json([    'status' => false,'message' => 'Beneficiary relief is already in the relief section'], 404);
      }else{
        $lifehood->charities_id = null;
        $lifehood->save();
      }

    }

    // Insert the transformed order with the first beneficiary education ID
    $beneficiaries_lifehood_id = $beneficiaries_reliefs->first()->id;



    $data = [
    'charities_id' => $charityId,
    'beneficiaries__reliefs_id' => $beneficiaries_lifehood_id,
    'reasonoftransformed' => $request->reasonoftransformed,
];

// Insert the data and get the ID of the newly inserted record
$insertedId = DB::table('orderstransoformedreliefs')->insertGetId($data);

// Retrieve the inserted record
$insertedData = DB::table('orderstransoformedreliefs')->where('id', $insertedId)->first();


    return response()->json([
          'status' => true,
        'message' => 'Order transformed successfully',
        'data' =>[ $beneficiaries_reliefs,'data'=>$insertedData],
        'pagination' => [
            'current_page' => 1,
            'total_pages' => 1,
            'total_items' => 1,
            'items_per_page' => 1,
        ],
    ], 201);
}
}
