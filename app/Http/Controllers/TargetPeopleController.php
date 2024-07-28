<?php

namespace App\Http\Controllers;

use App\Models\TargetPeople;
use App\Models\CharityTargetPeople;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TargetPeopleController extends Controller
{

    public function indexcharitytargetinformation(Request $request)
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
        $charityId = $charity->id;
        $charityTargetPeople = CharityTargetPeople::where('charities_id', $charityId)
         ->join('target_people', 'charity_target_people.target_people_id', '=', 'target_people.id')
         ->select('charity_target_people.*', 'target_people.*')
         ->paginate(10);

     return response()->json([
         'status' => true,
         'message' => 'Target people retrieved successfully',
         'data' => ['targetPeople' => $charityTargetPeople],
         'pagination' => [
             'current_page' => $charityTargetPeople->currentPage(),
             'total_pages' => $charityTargetPeople->lastPage(),
             'total_items' => $charityTargetPeople->total(),
             'items_per_page' => $charityTargetPeople->perPage(),
             'first_item' => $charityTargetPeople->firstItem(),
             'last_item' => $charityTargetPeople->lastItem(),
             'has_more_pages' => $charityTargetPeople->hasMorePages(),
             'next_page_url' => $charityTargetPeople->nextPageUrl(),
             'previous_page_url' => $charityTargetPeople->previousPageUrl(),
         ],
     ], 200);
 }
//هي بدها اعادة بناء الجداول
    public function completecharitytargetinformation(Request $request)
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
        $charityId = $charity->id;
        // Check if the charity already has target people information
          if (CharityTargetPeople::where('charities_id', $charityId)->exists()) {
              return response()->json([
                  'status' => false,
                  'message' => 'Target people information already exists for this charity.',
              ], 400);
          }

        $validator = Validator::make($request->all(), [

       'age' => 'nullable|integer',
       'babies' => 'nullable|boolean',
       'female' => 'nullable|boolean', // Assuming phone number has a max length of 15 characters
       'male' => 'nullable|boolean', // Assuming gender can be male, female, or other
       'elderly' => 'nullable|boolean', // Assuming birthday should be in Y-m-d format
       'youth' => 'nullable|boolean',
       'childern' => 'nullable|boolean',
       'vision_of_charity' => 'required|string',
       'charity_goals' => 'required|string', // Assuming phone number has a max length of 15 characters
       'charity_message' => 'required|string', // Assuming gender can be male, female, or other

]);
   // Custom validation rule to ensure at least one field is present
   $validator->after(function ($validator) use ($request) {
       if (
           !$request->has('age') &&
           !$request->has('babies') &&
           !$request->has('female') &&
           !$request->has('male')&&
           !$request->has('elderly') &&
           !$request->has('youth') &&
           !$request->has('childern')
       ) {
           $validator->errors()->add('fields', 'At least one of the following fields is required: age, babies, female, male,elderly,youth,childern');
       }
   });

   if ($validator->fails()) {
       return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
   }



      // Create location related to the charity
      $targetPeople = TargetPeople::create([
          'age' => $request->age,
          'babies' => $request->babies,
          'female' => $request->female,
          'male' => $request->male,
          'elderly' => $request->elderly,
        'youth' => $request->youth,
        'childern' => $request->childern,
      ]);

      $charitytargetPeople = CharityTargetPeople::create([
          'charities_id' => $charityId,
          'target_people_id' => $targetPeople->id,
          'vision_of_charity' =>$request->vision_of_charity,
          'charity_goals' =>$request->charity_goals,
          'charity_message' =>$request->charity_message,

      ]);

      return response()->json([
           'status' => true,
           'message' => 'you selected your target people  Successfully',
        //   'token' => $user->createToken("API TOKEN")->plainTextToken,
        'data' => [
             'targetPeople' => $targetPeople,
             'charitytargetPeople' => $charitytargetPeople
         ],
           'pagination' => [
             'current_page' => 1,
             'total_pages' => 1,
             'total_items' => 1,
             'items_per_page' => 1,
             'first_item' => 1,
             'last_item' => 1,
             'has_more_pages' => false,
             'next_page_url' => null,
             'previous_page_url' => null,
       ],
     ], 200);
    }


    public function updatecharitytargetinformation(Request $request)
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
      $charityId = $charity->id;

       $validatedCharityData = $request->validate([
           'vision_of_charity' => 'nullable|string',
           'charity_goals' => 'nullable|string',
           'charity_message' => 'nullable|string',
       ]);

       // Validate the target people data
       $validatedTargetData = $request->validate([
           'age' => 'nullable|integer',
           'babies' => 'nullable|integer',
           'female' => 'nullable|integer',
           'male' => 'nullable|integer',
           'elderly' => 'nullable|integer',
           'youth' => 'nullable|integer',
           'children' => 'nullable|integer',
       ]);

       // Remove empty values from validatedTargetData
       $validatedTargetData = array_filter($validatedTargetData, function($value) {
           return !is_null($value);
       });

       // Fetch and update charity target people records
       $charityTargetPeoples = CharityTargetPeople::where('charities_id', $charityId)->get();

       foreach ($charityTargetPeoples as $charityTargetPeopl) {
           // Update charity target information if there is data to update
           if (!empty($validatedCharityData)) {
               $charityTargetPeopl->update($validatedCharityData);
           }

           // Fetch the corresponding target people record
           $targetId = $charityTargetPeopl->target_people_id;

           // Update each target people record if there is data to update
           if (!empty($validatedTargetData)) {
               DB::table('target_people')
                   ->where('id', $targetId)
                   ->update($validatedTargetData);
           }
       }

       // Fetch the updated target people data with pagination
       $targetPeople = TargetPeople::whereIn('id', $charityTargetPeoples->pluck('target_people_id'))->paginate(10);

    return response()->json([
        'status' => true,
        'message' => 'Target people updated successfully',
        'data' =>['targetPeople' => $targetPeople],
        'pagination' => [
            'current_page' => $targetPeople->currentPage(),
            'total_pages' => $targetPeople->lastPage(),
            'total_items' => $targetPeople->total(),
            'items_per_page' => $targetPeople->perPage(),
            'first_item' => $targetPeople->firstItem(),
            'last_item' => $targetPeople->lastItem(),
            'has_more_pages' => $targetPeople->hasMorePages(),
            'next_page_url' => $targetPeople->nextPageUrl(),
            'previous_page_url' => $targetPeople->previousPageUrl(),
        ],
    ], 200);
}
}
