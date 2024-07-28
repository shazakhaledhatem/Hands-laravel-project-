<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Effectiveness;
use App\Models\LocationThatCoveredByCharities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class EffectivenessController extends Controller
{

 public function createeffectiveness(Request $request)
 {

     // Retrieve the authenticated charity's ID
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
         return response()->json([     'status' => false,'message' => 'Unauthorized'], 401);
     }

     // Validate that the token matches the latest token
     if ($charity->latest_token !== $hashedToken) {
         return response()->json([     'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
     }

     // Check if the token has the required capability
     if (!$charity->tokenCan('Charity Access Token')) {
         return response()->json([     'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
     }

     // Get the user ID
     $charityId = $charity->id;
     $validator = Validator::make($request->all(), [
        // 'image' => 'required|image|nullable',
         'name' => 'required|string',
         'type_of_effectiveness' => 'required|string|max:255',
         'initial_budget' => 'required|integer',
         'description' => 'required|string',
         'start_date' => 'required', // Uncomment if using
         'end_date' => 'required',
         'numberofvolunteer'=> 'required|integer',
         'numberofparicipations'=> 'required|integer', // Uncomment if using
     ]);

     if ($validator->fails()) {
         return response()->json(['status' => false,'message'=>'validation error','errors' => $validator->errors()], 422);
     }

     // Convert dates from d-m-Y to Y-m-d if included
   // $start_date = isset($request->start_date) ? Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d') : null;
   //  $end_date = isset($request->end_date) ? Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d') : null;
   $start_date = null;
   if ($request->has('start_date')) {
       try {
           $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date)->format('Y-m-d');
       } catch (\Exception $e) {
           try {
               $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
           } catch (\Exception $e) {
               return response()->json([
                   'status' => false,
                   'message' => 'Invalid start date format. Please use Y-m-d or d-m-Y.'
               ], 422);
           }
       }
   }

   $end_date = null;
   if ($request->has('end_date')) {
       try {
           $end_date = Carbon::createFromFormat('Y-m-d', $request->end_date)->format('Y-m-d');
       } catch (\Exception $e) {
           try {
               $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
           } catch (\Exception $e) {
               return response()->json([
                   'status' => false,
                   'message' => 'Invalid end date format. Please use Y-m-d or d-m-Y.'
               ], 422);
           }
       }
   }

     // Create location related to the charity
     $location = LocationThatCoveredByCharities::create([
         'governorate' => $request->governorate,
         'district' => $request->district,
         'sub_district' => $request->sub_district,
         'community' => $request->community,
         'street' => $request->street,
         'charities_id' => $charityId,
     ]);

     // Create the Effectiveness record
     $effectiveness = Effectiveness::create([
        //   'image' => $imagePath,
           'name'=>$request->name,
         'type_of_effectiveness' => $request->type_of_effectiveness,
         'initial_budget' => $request->initial_budget,
         'start_date' => $start_date,
         'end_date' => $end_date,
         'description' => $request->description,
         'location_that_covered_by_charities_id' => $location->id,
         'charities_id' => $charityId,
         'numberofvolunteer'=>$request->numberofvolunteer,
         'numberofparicipations'=>$request->numberofparicipations,
     ]);


     // Handle image storage
  if ($request->hasFile('image')) {
     $imagePath = $request->file('image')->store('public/effectiveness_images'); // Store image
     $imagePath = Storage::url($imagePath); // Get URL to saved image
      $effectiveness->image=$imagePath;
        $effectiveness->save();
  }
else{
    $effectiveness->image=null;
}


   //$effectiveness=['token' => $charity->createToken("API TOKEN")->plainTextToken,'charity' =>$charity];
    return response()->json([
         'status' => true,
         'message' => 'Effectiveness Created Successfully',
      //   'token' => $user->createToken("API TOKEN")->plainTextToken,
      'data' => [
           'effectiveness' => $effectiveness,
           'location' => $location
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


 public function update(Request $request, $id)
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
       return response()->json([     'status' => false,'message' => 'Unauthorized'], 401);
   }

   // Validate that the token matches the latest token
   if ($charity->latest_token !== $hashedToken) {
       return response()->json([     'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
   }

   // Check if the token has the required capability
   if (!$charity->tokenCan('Charity Access Token')) {
       return response()->json([     'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
   }

   // Get the user ID
   $charityId = $charity->id;

     $effectiveness = Effectiveness::find($id);
     if (!$effectiveness) {
         return response()->json([     'status' => false,'message' => 'Effectiveness not found'], 404);
     }

     // Update fields if they are present in the request
     if ($request->has('image')) {

         // Assuming the handling of image upload is necessary
         $path = $request->file('image')->store('public/effectiveness_images');
         $effectiveness->image = Storage::url($path);
     }

     $fieldsToUpdate = ['type_of_effectiveness', 'final_budget', 'description','numberofvolunteer','name','numberofparicipations'];
     foreach ($fieldsToUpdate as $field) {
         if ($request->has($field)) {
             $effectiveness->$field = $request->$field;
         }
     }
     $start_date = null;
     if ($request->has('start_date')) {
         try {
               $effectiveness->start_date = Carbon::createFromFormat('Y-m-d', $request->start_date)->format('Y-m-d');
                  $effectiveness->save();
         } catch (\Exception $e) {
             try {
                   $effectiveness->start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
                      $effectiveness->save();
             } catch (\Exception $e) {
                 return response()->json([
                     'status' => false,
                     'message' => 'Invalid start date format. Please use Y-m-d or d-m-Y.'
                 ], 422);
             }
         }
     }

     $end_date = null;
     if ($request->has('end_date')) {
         try {
             $effectiveness->end_date = Carbon::createFromFormat('Y-m-d', $request->end_date)->format('Y-m-d');
                 $effectiveness->save();
         } catch (\Exception $e) {
             try {
                 $effectiveness->end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
                     $effectiveness->save();
             } catch (\Exception $e) {
                 return response()->json([
                     'status' => false,
                     'message' => 'Invalid end date format. Please use Y-m-d or d-m-Y.'
                 ], 422);
             }
         }
     }



     $effectiveness->save();

     $location = LocationThatCoveredByCharities::where('id', $effectiveness->location_that_covered_by_charities_id)->first();
     if ($location) {
         $locationFields = ['governorate', 'district', 'sub_district', 'community', 'street'];
         foreach ($locationFields as $field) {
             if ($request->has($field)) {
                 $location->$field = $request->$field;
             }
         }
         $location->save();
     }

     // Repagination might be unnecessary here if only one record is updated
    // $effectivenessPaginated = Effectiveness::paginate(10);

     return response()->json([
         'status' => true,
         'message' => 'Effectiveness updated successfully',
         'data' => [
             'effectiveness' => $effectiveness,
             'location' => $location
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
public function index(Request $request){
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
      return response()->json([     'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
  }

  // Check if the token has the required capability
  if (!$charity->tokenCan('Charity Access Token')) {
      return response()->json([     'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
  }

  // Get the user ID
  $charityid = $charity->id;

    $effectiveness = Effectiveness::with('location')->where('charities_id',  $charityid)->paginate(10); // Adjust the pagination as needed


      return response()->json([
          'status' => true,
          'message' => 'effectiveness data retrieved successfully',  // Updated message
          'data' => $effectiveness->items(),  // Extracting items from paginator
          'pagination' => [
              'current_page' => $effectiveness->currentPage(),
              'total_pages' => $effectiveness->lastPage(),
              'total_items' => $effectiveness->total(),
              'items_per_page' => $effectiveness->perPage(),
              'first_item' => $effectiveness->firstItem(),
              'last_item' => $effectiveness->lastItem(),
              'has_more_pages' => $effectiveness->hasMorePages(),
              'next_page_url' => $effectiveness->nextPageUrl(),
              'previous_page_url' => $effectiveness->previousPageUrl(),
          ],
      ], 200);
  }


  public function show( $id)
  {
   $effectiveness = Effectiveness::with('location')->find($id);// Adjust the pagination as needed


      return response()->json([
        'status' => true,
        'message' => 'effectiveness data retrieved successfully',
        'data' => $effectiveness,
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


  public function destroy(Request $request, $id)
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
       return response()->json([     'status' => false,'message' => 'Unauthorized'], 401);
   }

   // Validate that the token matches the latest token
   if ($charity->latest_token !== $hashedToken) {
       return response()->json([     'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
   }

   // Check if the token has the required capability
   if (!$charity->tokenCan('Charity Access Token')) {
       return response()->json([     'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
   }

   // Get the user ID
   $charityId = $charity->id;

   $effectiveness = Effectiveness::with('location')->find($id);// Adjust the pagination as needed
if(! $effectiveness){
  return response()->json([     'status' => false,'message' => 'the effectiveness is not found'], 404);
}
    $effectiveness->delete();
    return response()->json([
      'status' => true,
      'message' => 'effectiveness data deleted successfully',
      'data' => [],
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
