<?php

namespace App\Http\Controllers;
use App\Models\Life_hood;
use App\Models\lifehood_charities;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class LifehoodCharitiesController extends Controller
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
            $lifehood_charities=lifehood_charities::where('charities_id',$charityId)->get();
$key=null;
          foreach ($lifehood_charities as $key ) {
          $key=  $key->life_hoods_id;
        }
          $life_hoods = DB::table('life_hoods')->where('id',$key)->get();


         return response()->json([
              'status' => true,
              'message' => 'get my speciication ',

           'data' => [' life_hoods' =>$life_hoods,
                    'lifehood_charities'=>$lifehood_charities,

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
     public function selectlifehoodsection(Request $request)
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
            'gainmoreexperienceinspecificfield' => 'nullable|boolean',
            'typeofworkthatyouwanttogain' => 'nullable|string|max:255',
            'jobapportunity' => 'nullable|boolean',
            'learningaprofession' => 'nullable|boolean',
        ]);

        // Custom validation rule to ensure at least one field is present
        $validator->after(function ($validator) use ($request) {
            if (
                !$request->has('gainmoreexperienceinspecificfield') &&
                !$request->has('typeofworkthatyouwanttogain') &&
                !$request->has('jobapportunity') &&
                !$request->has('learningaprofession')
            ) {
                $validator->errors()->add('fields', 'At least one of the following fields is required: gainmoreexperienceinspecificfield, typeofworkthatyouwanttogain, jobapportunity, learningaprofession');
            }
        });

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
       $lifehoodId = DB::table('life_hoods')->insertGetId([
            'gainmoreexperienceinspecificfield' => $request->input('gainmoreexperienceinspecificfield', false),
            'typeofworkthatyouwanttogain' => $request->input('typeofworkthatyouwanttogain'),
            'jobapportunity' => $request->input('jobapportunity', false),
            'learningaprofession' => $request->input('learningaprofession', false),

        ]);

 $lifehood_charities=lifehood_charities::create([
   'charities_id'=>$charityId,
   'life_hoods_id'=>$lifehoodId,
  // 'description'=> $request->input('description'),
 ]);

   $lifehood = Life_hood::where('id',$lifehoodId)->get();
 return response()->json([
      'status' => true,
      'message' => 'select lifehood section  Successfully',

   'data' => [' lifehood' =>$lifehood,
            'lifehood_charities'=>$lifehood_charities,

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
      public function updatelifehoodsection(Request $request)
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
        $lifehood_charities = lifehood_charities::where('charities_id', $charityId)->get();

               if ($request != null && $request->all()) {
                 foreach ($lifehood_charities as $lifehoodCharity) {
                     $lifehoodId = $lifehoodCharity->life_hoods_id;
                     $requests=$request->all();

                     DB::table('life_hoods')
                         ->where('id', $lifehoodId)
                         ->update( $requests);

                     $lifehoodCharity->update($requests);
                 }
                $lifehood = Life_hood::where('id',$lifehoodId)->get();
                return response()->json([
                    'status' => true,
                    'message' => 'Update lifehood section successfully',
                    'data' => [
                        'lifehood' => $lifehood,
                        'lifehood_charities' => $lifehood_charities,
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
                 foreach ($lifehood_charities as $lifehoodCharity) {
                     $lifehoodId = $lifehoodCharity->life_hoods_id;


                     DB::table('life_hoods')
                         ->where('id', $lifehoodId);




                 }


                $lifehood = Life_hood::where('id',$lifehoodId)->get();


             }

             return response()->json([
                 'status' => true,
                 'message' => 'nothing updated',
                 'data' => [
                     'lifehood' => $lifehood,
                     'lifehood_charities' => $lifehood_charities,
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
