<?php

namespace App\Http\Controllers;

use App\Models\Orderesfromemergencystatus;
use App\Models\Factrsofemergencystatus;
use Illuminate\Http\Request;
use Auth;
use App\Models\EmeregencyStatus;
use App\Events\emergencyorder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
class OrderesfromemergencystatusController extends Controller
{
  public function beneficiaryemergencyorder(Request $request) {

    $user = Auth::guard('api')->user(); // Authentication for API guard
      if (!$user) {
          return response()->json(['status'=>false,'message' => 'Unauthorized'], 401);
      }

      $userid = $user->id;
//dd($request);
      // Check if a similar health order already exists
      $existingOrder = Orderesfromemergencystatus::where([
          ['description', '=', $request->description],
          ['first_name', '=', $request->first_name],
          ['last_name', '=', $request->last_name],
          ['phone', '=', $request->phone],
          ['gender', '=', $request->gender],
          ['birthday', '=', $request->birthday],
          ['address', '=', $request->address],
          ['needs', '=', $request->needs],
          ['status', '=', $request->status],

      ])->exists();
      if ($existingOrder) {
          return response()->json(['status'=>false,
            'message' => 'You have already made a similar order.'], 409);
      }

      try {
          DB::beginTransaction();

                $validator = Validator::make($request->all(), [
                       'first_name' => 'required|string|max:255',
                       'last_name' => 'required|string|max:255',
                       'phone' => 'required|string',
                       'gender' => 'required|in:male,female,other',
                       'birthday' => 'required',
                    //   'needs' => 'required|array',
                               'needs.*' => 'array',
                       'address' => 'required|string|max:255',
                       'description' => 'required|string|max:255'

                   ]);

              if ($validator->fails()) {
              return response()->json(['status' => false,
               'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
              }
$date = null;

if (isset($request->birthday)) {
try {
    // Try to parse the date in 'd-m-Y' format
    $birthday = Carbon::createFromFormat('d-m-Y', $request->birthday)->format('Y-m-d');
} catch (\Exception $e) {
    try {
        // If 'd-m-Y' format fails, try 'Y-m-d' format
        $birthday = Carbon::createFromFormat('Y-m-d', $request->birthday)->format('Y-m-d');
    } catch (\Exception $e) {
        // If both formats fail, handle the error or set to null
        $birthday = null;
    }
}
}
          $Orderesfromemergencystatus = Orderesfromemergencystatus::create([
              //'charities_id' => $request->input('typeofdisease'),
              'first_name'=> $request->first_name,
              'last_name'=> $request->last_name,
              'phone'=> $request->phone,
              'gender'=>$request->gender,
              'birthday'=> $request->birthday,
              'address'=> $request->address,
              'needs'=> $request->needs,
              'description'=> $request->description,
             'user_id'=>$userid,

          ]);



          DB::commit();


          return response()->json([
            'status'=>true,
              'message' => 'Your emergence order was submitted successfully.',
              'data' => $Orderesfromemergencystatus,
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
      } catch (\Exception $e) {
          DB::rollback();
          return response()->json(['message' => 'Error processing your request: ' . $e->getMessage()], 500);
      }
    }


    public function proccessemergencyorder(Request $request,$id)
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
    $charityId = $charity->id;
    $order = Orderesfromemergencystatus::findOrFail($id);

    if($order->status =='Pending'){
        $order->charities_id=$charityId;
      $order->status = 'Completed'; // Ensure 'accept' is a valid enum value
      $order->save();

    }

    //   event(new emergencyorder($order));

       return response()->json([
           'status' => true,
           'message' => 'Your emergence order was process successfully.',
           'data' => $order,
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

   public function showemergencyorder(Request $request)
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
   $order = Orderesfromemergencystatus::where('status','Pending');
   $orders = $order->paginate(10);

     // Return response with orders and pagination details
     return response()->json([
         'status' => true,
         'message' => 'Your emergency order presented successfully.',
         'data' => $orders->items(), // Get the items for the current page
         'pagination' => [
             'current_page' => $orders->currentPage(),
             'total_pages' => $orders->lastPage(),
             'total_items' => $orders->total(),
             'items_per_page' => $orders->perPage(),
             'first_item' => $orders->firstItem(),
             'last_item' => $orders->lastItem(),
             'has_more_pages' => $orders->hasMorePages(),
             'next_page_url' => $orders->nextPageUrl(),
             'previous_page_url' => $orders->previousPageUrl(),
         ],
     ], 200);

 }


 public function detailsemergencyorder(Request $request,$id)
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

  $order = Orderesfromemergencystatus::where('charities_id',$charityId)->find($id);

   // Check if the order exists
   if (!$order) {
       return response()->json([
           'status' => false,
           'message' => 'Order not found.',
       ], 404);
   }

   return response()->json([
       'status' => true,
       'message' => 'Your emergency order presented details successfully.',
       'data' => $order, // Get the items for the current page
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


public function getneeds()
{
//   $emergencystatus=EmeregencyStatus::where('active', 1)->get();
//
// $emergency = Factrsofemergencystatus::select('id','type')
// ->where('emergencystatus_id',  $emergencystatus->id)
//  ->get();
$emergencystatuses = EmeregencyStatus::where('active', 1)->get();

// Initialize an empty collection for the emergency factors
$emergencyFactors = collect();

// Iterate over each active emergency status and retrieve corresponding factors
foreach ($emergencystatuses as $status) {
    $factors = Factrsofemergencystatus::select('id', 'type')
        ->where('emergencystatus_id', $status->id)
        ->get();
    // Merge the factors into the main collection
    $emergencyFactors = $emergencyFactors->merge($factors);
}
return response()->json([
    'message' => 'emergency needs',
    'data' => $emergencyFactors,
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
