<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Finiancialreports;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FiniancialreportController extends Controller
{
  public function index(Request $request)
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
   $charityId=$charity->id;
      $donations_report = Finiancialreports::where('charities_id',$charityId)->paginate(10); // Adjust the number 10 to your desired pagination size

      return response()->json([
          'status' => true,
          'message' => 'all reports get Successfully',
        //  'token' => $user->createToken("API TOKEN")->plainTextToken,
          'data' => $donations_report,
          'pagination' => [
          'current_page' => $donations_report->currentPage(),
          'total_pages' => $donations_report->lastPage(),
          'total_items' => $donations_report->total(),
          'items_per_page' => $donations_report->perPage(),
          'first_item' => $donations_report->firstItem(),
          'last_item' => $donations_report->lastItem(),
          'has_more_pages' => $donations_report->hasMorePages(),
          'next_page_url' => $donations_report->nextPageUrl(),
          'previous_page_url' => $donations_report->previousPageUrl(),
      ],
      ], 200);
  }

  public function create(Request $request)
  {
    // Get the authenticated charity user
    $charity = Auth::guard('api-charities')->user();

    // Check if the charity user is authenticated
    if (!$charity) {
        return response()->json([  'status' => false,'message' => 'Unauthorized'], 401);
    }

    // Get all charities
    $donations_report = Donation::all();

    // Extract the id and name of the charities
    $donations_reportData = $donations_report->map(function($report) {
        return [
            'id' => $report->id,
            'name' => $report->name
        ];
    });

    // Return the list of charity id and name
    return response()->json([
        'status' => true,
        'message' => 'charity selected successfully',
        'data' => $donations_reportData,
        'pagination' => [
            'current_page' => 1,
            'total_pages' => 1,
            'total_items' => 1,
            'items_per_page' => 1,
        ],
    ], 201);







  }



  public function store(Request $request, $donationId)
  {
      // Authenticate the charity
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

      $validator = Validator::make($request->all(), [
             'description' => 'required|string|max:255',
             'date' => 'required'


         ]);

    if ($validator->fails()) {
    return response()->json(['status' => false,
     'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
    }

      $date = null;

  if (isset($request->date)) {
      try {
          // Try to parse the date in 'd-m-Y' format
          $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
      } catch (\Exception $e) {
          try {
              // If 'd-m-Y' format fails, try 'Y-m-d' format
              $date = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');
          } catch (\Exception $e) {
              // If both formats fail, handle the error or set to null
              $date = null;
          }
      }
  }

      // Create the financial report
      $donations_report = Finiancialreports::create([
          'charities_id' => $charityId,
          'donation_id' => $donationId,
          'date' => $date,
          'description' => $request->description
      ]);

      return response()->json([
          'status' => true,
          'message' => 'Created report successfully',
          'data' => $donations_report,
          'pagination' => [
              'current_page' => 1,
              'total_pages' => 1,
              'total_items' => 1,
              'items_per_page' => 1,
          ],
      ], 200);
  }

  public function update(Request $request, $id)
{
    // Authenticate the charity
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

    // Convert the date format if provided
    $data = $request->all();
    $date = null;

if (isset($request->date)) {
    try {
        // Try to parse the date in 'd-m-Y' format
        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
    } catch (\Exception $e) {
        try {
            // If 'd-m-Y' format fails, try 'Y-m-d' format
            $date = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');
        } catch (\Exception $e) {
            // If both formats fail, handle the error or set to null
            $date = null;
        }
    }
}

    // Find the financial report by ID and ensure it belongs to the authenticated charity
    $financialReport = Finiancialreports::where('id', $id)->findOrFail($id);

    // Update the financial report with the data
    $financialReport->update($data);

    return response()->json([
        'status' => true,
        'message' => 'Updated report successfully',
        'data' => $financialReport,
    ], 200);
}



public function destroy(Request $request,$id)
{
    // Authenticate the charity
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

    // Find the financial report by ID and ensure it belongs to the authenticated charity
    $financialReport = Finiancialreports::where('id', $id)->findOrFail($id);

    // Delete the financial report
    $financialReport->delete();

    return response()->json([
        'status' => true,
        'message' => 'Deleted report successfully',
        'pagination' => [
            'current_page' => 1,
            'total_pages' => 1,
            'total_items' => 1,
            'items_per_page' => 1,
        ],
    ], 200);
}


}
