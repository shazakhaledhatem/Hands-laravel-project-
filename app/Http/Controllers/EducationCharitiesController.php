<?php

namespace App\Http\Controllers;

use App\Models\education_charities;
use App\Models\Education;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
class EducationCharitiesController extends Controller
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
       $education_charities=education_charities::where('charities_id',$charityId)->get();
        $id=null;
     foreach ($education_charities as $key ) {

     $id = $key->education_id;
   }
     $education = DB::table('education')->where('id',$id)->get();

    //$education = DB::table('education')->paginate(10);
    return response()->json([
         'status' => true,
         'message' => 'get my speciication ',

      'data' => [' education' =>$education,
               'education_charities'=>$education_charities,

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

     public function selecteducationsection(Request $request)
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
              'typeofeducation' => 'required|string|max:255',
              'clothes' => 'nullable|boolean',
              'booksandpens' => 'nullable|boolean',
              'courses' => 'nullable|boolean',
              'bags' => 'nullable|boolean',
          ]);

if ($validator->fails()) {
    return response()->json(['status' => false,
      'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
}


       $educationId = DB::table('education')->insertGetId([
         'typeofeducation' => $request->input('typeofeducation'),
     'clothes'=> $request->input('clothes', false),
     'booksandpens'=> $request->input('booksandpens', false),
     'courses'=> $request->input('courses', false),
     'bags'=> $request->input('bags', false)

        ]);

 $educationcharitie=education_charities::create([
   'charities_id'=>$charityId,
   'education_id'=>$educationId,
  // 'description'=> $request->input('description'),
 ]);

   $education = Education::where('id',$educationId)->get();
 return response()->json([
      'status' => true,
      'message' => 'select education section  Successfully',

   'data' => [' education' =>$education,
            'educationcharitie'=>$educationcharitie,

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
      public function updateducationsection(Request $request)
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

        $educationCharities = education_charities::where('charities_id', $charityId)->get();

        if ($request != null && $request->all()) {

            foreach ($educationCharities as $educationCharity) {

                $educationId = $educationCharity->education_id;
                $updateData = $request->all();
                DB::table('education')
                    ->where('id', $educationId)
                    ->update($updateData);
                $educationCharity->update($updateData);
            }

$education = Education::where('id',$educationId)->get();
            return response()->json([
                'status' => true,
                'message' => 'Education records updated successfully',
                'data' => [
                    'education' => $education,
                    'educationCharities' => $educationCharities,
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
        } else {
          foreach ($educationCharities as $educationCharity) {
              $educationId = $educationCharity->education_id;
              // Update the education table
              DB::table('education')
                  ->where('id', $educationId);
          }
$education = Education::where('id',$educationId)->get();
            return response()->json([
                'status' => true,
                'message' => 'Nothing updated',
                'data' => [
                    'education' => $education,
                    'educationCharities' => $educationCharities,
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
}
}
