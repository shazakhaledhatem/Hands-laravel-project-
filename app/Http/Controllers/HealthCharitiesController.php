<?php

namespace App\Http\Controllers;

use App\Models\health_charities;
use App\Models\Health;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HealthCharitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
          return response()->json(['status' => false,'message' => 'Unauthorized'], 401);
      }

      // Validate that the token matches the latest token
      if ($charity->latest_token !== $hashedToken) {
          return response()->json(['status' => false,'message' => 'Unauthorized: Invalid token'], 401);
      }

      // Check if the token has the required capability
      if (!$charity->tokenCan('Charity Access Token')) {
          return response()->json(['status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
      }

      // Get the user ID
      $charityId = $charity->id;
      $health_charities=health_charities::where('charities_id',$charityId)->get();
$key=null;
    foreach ($health_charities as $key ) {
    $key=  $key->healths_id;
  }
    $health = DB::table('healths')->where('id',$key)->get();

  // $health = DB::table('healths')->paginate(10);
   return response()->json([
        'status' => true,
        'message' => 'get my speciication ',

     'data' => [' health' =>$health,
              'health_charities'=>$health_charities,

   ],


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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selecthealthsection(Request $request)
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
          return response()->json(['status' => false,'message' => 'Unauthorized'], 401);
      }

      // Validate that the token matches the latest token
      if ($charity->latest_token !== $hashedToken) {
          return response()->json(['status' => false,'message' => 'Unauthorized: Invalid token'], 401);
      }

      // Check if the token has the required capability
      if (!$charity->tokenCan('Charity Access Token')) {
          return response()->json(['status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
      }

      // Get the user ID
      $charityId = $charity->id;
      $validator = Validator::make($request->all(), [
             'typeofdisease' => 'required|string|max:255',
             'operation' => 'nullable|boolean',
             'doctorcheck' => 'nullable|boolean',
             'medicaldevice' => 'nullable|boolean',
             'typeofdevice' => 'nullable|string|max:255',
             'milkanddiaper' => 'nullable|boolean',
         ]);

if ($validator->fails()) {
   return response()->json(['status' => false,
     'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
}

      $healthId = DB::table('healths')->insertGetId([
           'typeofdisease' => $request->input('typeofdisease'),
           'operation' => $request->input('operation', false),
           'doctorcheck' => $request->input('doctorcheck', false),
           'medicine' => $request->input('medicine', false),
           'medicaldevice' => $request->input('medicaldevice', false),
           'typeofdevice' => $request->input('typeofdevice'),
           'milkanddiaper' => $request->input('milkanddiaper', false),
       ]);

$healthcharitie=health_charities::create([
  'charities_id'=>$charityId,
  'healths_id'=>$healthId,
  //'description'=> $request->input('description'),
]);

  $health = Health::where('id',$healthId)->get();
return response()->json([
     'status' => true,
     'message' => 'select health section  Successfully',

  'data' => [' health' =>$health,
           'healthcharitie'=>$healthcharitie,

],


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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function updatehealthsection(Request $request)
   {
     $token = $request->header('Authorization');
     if (!$token)  {
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
         return response()->json(['status' => false,'message' => 'Unauthorized'], 401);
     }

     // Validate that the token matches the latest token
     if ($charity->latest_token !== $hashedToken) {
         return response()->json(['status' => false,'message' => 'Unauthorized: Invalid token'], 401);
     }

     // Check if the token has the required capability
     if (!$charity->tokenCan('Charity Access Token')) {
         return response()->json(['status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
     }

     // Get the user ID
     $charityId = $charity->id;
       $healthCharities = health_charities::where('charities_id', $charityId)->get();

       if ($request != null && $request->all()) {
         foreach ($healthCharities as $healthCharity) {

             $healthId = $healthCharity->healths_id;
             $updateData = $request->all();
             DB::table('healths')
                 ->where('id', $healthId)
                 ->update($updateData);
             $healthCharity->update($updateData);
         }

         $health = Health::where('id',$healthId)->get();
         
         return response()->json([
             'status' => true,
             'message' => 'Update health section successfully',
             'data' => [
                 'health' => $health,
                 'healthCharity' => $healthCharity,
             ],
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
       } else {
         foreach ($healthCharities as $healthCharity) {
             $healthId = $healthCharity->healths_id;


             DB::table('healths')
                 ->where('id', $healthId);

         }

         $health = Health::where('id',$healthId)->get();
         return response()->json([
             'status' => true,
             'message' => 'nothing updated',
             'data' => [
                 'health' => $health,
                 'healthCharity' => $healthCharity,
             ],
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
}
