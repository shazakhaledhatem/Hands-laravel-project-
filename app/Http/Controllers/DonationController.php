<?php
namespace App\Http\Controllers;
use App\Models\Donation;
use App\Models\Finiancialreports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Models\Charity;
class DonationController extends Controller
{
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
          return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
      }

      // Validate that the token matches the latest token
      if ($charity->latest_token !== $hashedToken) {
          return response()->json(['status' => false, 'message' => 'Unauthorized: Invalid token'], 401);
      }

      // Check if the token has the required capability
      if (!$charity->tokenCan('Charity Access Token')) {
          return response()->json(['status' => false, 'message' => 'Unauthorized: Token does not have the required capability.'], 403);
      }

      // Get the charity ID
      $charityId = $charity->id;
      $donations = Donation::where('charities_id', $charityId)->paginate(10); // Adjust the number '10' to the desired items per page

      if ($donations->isEmpty()) {
          return response()->json(['status' => false, 'message' => 'No donations found for this charity.'], 404);
      }

      return response()->json([
          'status' => true,
          'message' => 'All donations',
          'data' => $donations->items(),
          'pagination' => [
              'current_page' => $donations->currentPage(),
              'total_pages' => $donations->lastPage(),
              'total_items' => $donations->total(),
              'items_per_page' => $donations->perPage(),
              'first_item' => $donations->firstItem(),
              'last_item' => $donations->lastItem(),
              'has_more_pages' => $donations->hasMorePages(),
              'next_page_url' => $donations->nextPageUrl(),
              'previous_page_url' => $donations->previousPageUrl(),
          ],
      ], 200);
  }


public function create(Request $request, $charityId)
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
    $user = Auth::guard('api')->user();

    // Check if user is authenticated
    if (!$user) {
        return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
    }

    // Validate that the token matches the latest token
    if ($user->latest_token !== $hashedToken) {
        return response()->json(['status' => false, 'message' => 'Unauthorized: Invalid token'], 401);
    }

    // Check if the token has the required capability
    if (!$user->tokenCan('API TOKEN')) {
        return response()->json(['status' => false, 'message' => 'Unauthorized: Token does not have the required capability.'], 403);
    }

    $userId = $user->id;

    // Sanitize input
    $sanitizedData = $request->all();
    $sanitizedData['name'] = trim(preg_replace('/\r\n|\r|\n/', '', stripslashes($sanitizedData['name'])));

    $validator = Validator::make($sanitizedData, [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'image' => 'required|image',
        'amount' => 'required|integer',
        'number_bill' => 'required|integer',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
    }

    if ($request->hasFile('image')) {
        // Store the image in the 'public/donations_images' directory
        $imagePath = $request->file('image')->store('public/donations_images');
        // Get the URL to the saved image
        $imagePath = Storage::url($imagePath);
    }

    // Create a new donation entry with the provided data
    $donations = Donation::create([
        'charities_id' => $charityId,
        'name' => $sanitizedData['name'],
        'phone' => $sanitizedData['phone'],
        'image' => $imagePath,
        'amount' => $sanitizedData['amount'],
        'number_bill' => $sanitizedData['number_bill'],
        'userid'=>$userId,
    ]);

    // Prepare the response data
    return response()->json([
        'status' => true,
        'message' => 'You insert donation successfully',
        'data' => $donations,
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

  public function getcharityname(Request $request)
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
    $user = Auth::guard('api')->user();

    // Check if user is authenticated
    if (!$user) {
        return response()->json(['status' => false,'message' => 'Unauthorized'], 401);
    }

    // Validate that the token matches the latest token
    if ($user->latest_token !== $hashedToken) {
        return response()->json(['status' => false,'message' => 'Unauthorized: Invalid token'], 401);
    }

    // Check if the token has the required capability
    if (!$user->tokenCan('API TOKEN')) {
        return response()->json(['status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
    }

    // Get the user ID
    $userid = $user->id;

$charities=Charity::all();

return response()->json([
    'status' => true,
    'message' => 'name of charity to donate',
    'data' => $charities,
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

public function show($donationId){
$donations=Donation::where('id',$donationId)->get();
return response()->json([
    'status' => true,
    'message' => 'dtailes of  donation',
    'data' => $donations,
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

public function getFinancialReportsByUserId(Request $request)
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
    $user = Auth::guard('api')->user();

    // Check if user is authenticated
    if (!$user) {
        return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
    }

    // Validate that the token matches the latest token
    if ($user->latest_token !== $hashedToken) {
        return response()->json(['status' => false, 'message' => 'Unauthorized: Invalid token'], 401);
    }

    // Check if the token has the required capability
    if (!$user->tokenCan('User Access Token')) {
        return response()->json(['status' => false, 'message' => 'Unauthorized: Token does not have the required capability.'], 403);
    }

    // Get the user ID
    $userId = $user->id;

    // Get donations for the user
    $donations = Donation::where('userid', $userId)->pluck('id');

    if ($donations->isEmpty()) {
        return response()->json(['status' => false, 'message' => 'No donations found for this user.'], 404);
    }

    // Get financial reports for the donations
    $financialReports = Finiancialreports::whereIn('donation_id', $donations)->paginate(10);

    if ($financialReports->isEmpty()) {
        return response()->json(['status' => false, 'message' => 'No financial reports found for this user.'], 404);
    }

    return response()->json([
        'status' => true,
        'message' => 'Financial reports',
        'data' => $financialReports->items(),
        'pagination' => [
            'current_page' => $financialReports->currentPage(),
            'total_pages' => $financialReports->lastPage(),
            'total_items' => $financialReports->total(),
            'items_per_page' => $financialReports->perPage(),
            'first_item' => $financialReports->firstItem(),
            'last_item' => $financialReports->lastItem(),
            'has_more_pages' => $financialReports->hasMorePages(),
            'next_page_url' => $financialReports->nextPageUrl(),
            'previous_page_url' => $financialReports->previousPageUrl(),
        ],
    ], 200);
}


  }
