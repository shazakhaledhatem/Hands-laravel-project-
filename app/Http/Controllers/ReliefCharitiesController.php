<?php

namespace App\Http\Controllers;

use App\Models\relief_charities;
use App\Models\Relief;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class ReliefCharitiesController extends Controller
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
       $relief_charities=relief_charities::where('charities_id',$charityId)->get();
$key=null;
     foreach ($relief_charities as $key ) {
     $key=  $key->reliefs_id;
   }
     $reliefs = DB::table('reliefs')->where('id',$key)->get();

  //  $reliefs = DB::table('reliefs')->paginate(10);
    return response()->json([
         'status' => true,
         'message' => 'get my speciication ',

      'data' => [' reliefs' =>$reliefs,
               'relief_charities'=>$relief_charities,

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
     public function selectreliefsection(Request $request)
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
            'home' => 'nullable|boolean',
            'housefurniture' => 'nullable|boolean',
            'food' => 'nullable|boolean',
              'clothes' => 'nullable|boolean',
                'money' => 'nullable|boolean',
                  'psychologicalaid' => 'nullable|boolean',
        ]);

        // Custom validation rule to ensure at least one field is present
        $validator->after(function ($validator) use ($request) {
            if (
                !$request->has('home') &&
                !$request->has('housefurniture') &&
                !$request->has('food') &&
                  !$request->has('clothes') &&
                    !$request->has('money') &&
                !$request->has('psychologicalaid')
            ) {
                $validator->errors()->add('fields', 'At least one of the following fields is required: home, housefurniture, food, clothes,money,psychologicalaid');
            }
        });

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
       $reliefId = DB::table('reliefs')->insertGetId([
            'home' => $request->input('home', false),
            'housefurniture' => $request->input('housefurniture', false),
            'food' => $request->input('food', false),
            'clothes' => $request->input('clothes', false),
            'money' => $request->input('money', false),
            'psychologicalaid' => $request->input('psychologicalaid', false),

        ]);


 $reliefcharitie=relief_charities::create([
   'charities_id'=>$charityId,
   'reliefs_id'=>$reliefId,
   //'description'=> $request->input('description'),
 ]);

   $reliefs =Relief::where('id',$reliefId)->get();
 return response()->json([
      'status' => true,
      'message' => 'select relief section  Successfully',

   'data' => [' reliefs' =>$reliefs,
            'reliefcharitie'=>$reliefcharitie,

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
      public function updatereliefsection(Request $request)
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
        $reliefCharities = relief_charities::where('charities_id', $charityId)->get();

        if ($request != null && $request->all()) {

                  foreach ($reliefCharities as $reliefCharity) {
                      $reliefId = $reliefCharity->reliefs_id;

                  $requests=$request->all();
                      DB::table('reliefs')
                          ->where('id', $reliefId)
                          ->update($requests);

                      $reliefCharity->update($requests);



                  }


                $reliefs =Relief::where('id',$reliefId)->get();

                return response()->json([
                    'status' => true,
                    'message' => 'Update relief section successfully',
                    'data' => [
                        'relief' => $reliefs,
                        'reliefCharities' => $reliefCharities,
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
          foreach ($reliefCharities as $reliefCharity) {
              $reliefId = $reliefCharity->reliefs_id;

          $requests=$request->all();
              DB::table('reliefs')
                  ->where('id', $reliefId);



          }


        $reliefs =Relief::where('id',$reliefId)->get();

        return response()->json([
            'status' => true,
            'message' => 'nothing updated',
            'data' => [
                'relief' => $reliefs,
                'reliefCharities' => $reliefCharities,
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
