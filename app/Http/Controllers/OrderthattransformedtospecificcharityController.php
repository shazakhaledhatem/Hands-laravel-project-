<?php

namespace App\Http\Controllers;

use App\Models\Orderthattransformedtospecificcharity;
use Illuminate\Http\Request;
use App\Models\Charity;
use App\Models\Beneficiary;
use App\Models\Beneficiary_Health;
use App\Models\Beneficiary_Lifehood;
use App\Models\Beneficiary_Relief;
use App\Models\Beneficiary_Education;
use Illuminate\Support\Facades\DB;
use Auth;

class OrderthattransformedtospecificcharityController extends Controller
{

  public function transformCharity(Request $request, $charityId, $orderId)
  {
      // Retrieve the authenticated user
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
      $authCharityId = $charity->id;

      // Initialize the variable to store the found records
      $foundRecords = null;
      $recordType = null;

      // Array to store the different beneficiary models
      $beneficiaryModels = [
          'health' => Beneficiary_Health::class,
          'education' => Beneficiary_Education::class,
          'relief' => Beneficiary_Relief::class,
          'lifehood' => Beneficiary_Lifehood::class,
      ];

      // Iterate through each type of beneficiary model to find records
      foreach ($beneficiaryModels as $type => $model) {
          $records = $model::where('beneficiaries_id', $orderId)->get();
          if (!$records->isEmpty()) {
              $foundRecords = $records;
              $recordType = $type;
              break; // Exit the loop once records are found
          }
      }

      // If no records are found, return an error response
      if ($foundRecords === null) {
          return response()->json([    'status' => false,'message' => 'No beneficiary records found'], 404);
      }

      // Process the found records
     foreach ($foundRecords as $record) {

              $record->charities_id = $charityId;
              $record->status="pending";
              $record->save();

      }

      $data = [
          'charities_id' => $authCharityId,
          'charitythatrecieveorder_id' => $charityId,
          'reasonoftransformed' => $request->reasonoftransformed,
      ];

      $insertedId = DB::table('ordertransspecificcharities')->insertGetId($data);
      $insertedData = DB::table('ordertransspecificcharities')->where('id', $insertedId)->first();

      return response()->json([
            'status' => true,
          'message' => 'Order transformed successfully',
          'data' => [$foundRecords, 'data' => $insertedData],
          'record_type' => $recordType,
          'pagination' => [
              'current_page' => 1,
              'total_pages' => 1,
              'total_items' => 1,
              'items_per_page' => 1,
          ],
      ], 201);
  }

public function indexCharitiesInTransformPage(Request $request)
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
      $authCharityId = $charity->id;
    // Get all charities
  $charities = Charity::where('id', '!=', $authCharityId)->get();



    // Extract the id and name of the charities
    $charityData = $charities->map(function($charity) {
        return [
            'id' => $charity->id,
            'name' => $charity->name
        ];
    });

    // Return the list of charity id and name
    return response()->json([
          'status' => true,
        'message' => 'charity selected successfully',
        'data' => $charityData,
        'pagination' => [
            'current_page' => 1,
            'total_pages' => 1,
            'total_items' => 1,
            'items_per_page' => 1,
        ],
    ], 201);
}
}
