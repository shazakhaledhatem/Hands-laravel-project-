<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Effectivenessreports;
use App\Models\Effectiveness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EffectivenessreportsController extends Controller
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
        return response()->json(['status'=>false,
          'message' => 'Unauthorized'], 401);
    }

    // Validate that the token matches the latest token
    if ($charity->latest_token !== $hashedToken) {
        return response()->json(['status'=>false,'message' => 'Unauthorized: Invalid token'], 401);
    }

    // Check if the token has the required capability
    if (!$charity->tokenCan('Charity Access Token')) {
        return response()->json(['status'=>false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
    }

    // Get the user ID
    $charityId = $charity->id;
      $effectiveness_report = Effectivenessreports::where('charities_id',$charityId)->paginate(10); // Adjust the number 10 to your desired pagination size

      return response()->json([
          'status' => true,
          'message' => 'all reports get Successfully',
        //  'token' => $user->createToken("API TOKEN")->plainTextToken,
          'data' => $effectiveness_report,
          'pagination' => [
          'current_page' => $effectiveness_report->currentPage(),
          'total_pages' => $effectiveness_report->lastPage(),
          'total_items' => $effectiveness_report->total(),
          'items_per_page' => $effectiveness_report->perPage(),
          'first_item' => $effectiveness_report->firstItem(),
          'last_item' => $effectiveness_report->lastItem(),
          'has_more_pages' => $effectiveness_report->hasMorePages(),
          'next_page_url' => $effectiveness_report->nextPageUrl(),
          'previous_page_url' => $effectiveness_report->previousPageUrl(),
      ],
      ], 200);
  }
//يعيد اسماء الفعاليات منشان اختار وحدة منن و اعمل تاقرير عليها
  public function create(Request $request)
  {
    // Get the authenticated charity user
    $charity = Auth::guard('api-charities')->user();

    // Check if the charity user is authenticated
    if (!$charity) {
        return response()->json(['status'=>false,'message' => 'Unauthorized'], 401);
    }

    // Get all charities
    $effectiveness = Effectiveness::all();

    // Extract the id and name of the charities
    $effectiveness_data = $effectiveness->map(function($report) {
        return [
            'id' => $report->id,
            'name' => $report->name
        ];
    });
    return response()->json([
      'status'=>true,
        'message' => 'effectiveness selected successfully',
        'data' => $effectiveness_data,
        'pagination' => [
            'current_page' => 1,
            'total_pages' => 1,
            'total_items' => 1,
            'items_per_page' => 1,
        ],
    ], 201);

  }

  public function store(Request $request, $effectivenessId)
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
        return response()->json(['status'=>false,'message' => 'Unauthorized'], 401);
    }

    // Validate that the token matches the latest token
    if ($charity->latest_token !== $hashedToken) {
        return response()->json(['status'=>false,'message' => 'Unauthorized: Invalid token'], 401);
    }

    // Check if the token has the required capability
    if (!$charity->tokenCan('Charity Access Token')) {
        return response()->json(['status'=>false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
    }

    // Get the user ID
    $charityId = $charity->id;
    $validator = Validator::make($request->all(), [
           'date' => 'required',
           'description' => 'required|string|max:255',
           'final_budget' => 'required|integer'

       ]);

    if ($validator->fails()) {
    return response()->json(['status' => false,
    'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
    }
    $date = null;
if (isset($request->date)) {
  try {
      $date = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');
  } catch (\Exception $e) {
      try {
          $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
      } catch (\Exception $e) {
          return response()->json([
              'status' => false,
              'message' => 'Invalid date format. Please use Y-m-d or d-m-Y.'
          ], 422);
      }
  }
}


      $effectiveness_report = Effectivenessreports::create([
          'charities_id' => $charityId,
          'effectivenesses_id' => $effectivenessId,
          'date' => $date,
          'description' => $request->description,
          'final_budget'=> $request->final_budget,
      ]);

      return response()->json([
          'status' => true,
          'message' => 'Created report successfully',
          'data' => $effectiveness_report,
          'pagination' => [
              'current_page' => 1,
              'total_pages' => 1,
              'total_items' => 1,
              'items_per_page' => 1,
          ],
      ], 201);
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
      return response()->json(['status'=>false,'message' => 'Unauthorized'], 401);
  }

  // Validate that the token matches the latest token
  if ($charity->latest_token !== $hashedToken) {
      return response()->json(['status'=>false,'message' => 'Unauthorized: Invalid token'], 401);
  }

  // Check if the token has the required capability
  if (!$charity->tokenCan('Charity Access Token')) {
      return response()->json(['status'=>false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
  }

    $data = $request->all();

  /*  if ($request->has('date')) {
        $data['date'] = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
    }*/
    $date = null;
if (isset($request->date)) {
  try {
      $data['date'] = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');
  } catch (\Exception $e) {
      try {
        $data['date'] = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
      } catch (\Exception $e) {
          return response()->json([
              'status' => false,
              'message' => 'Invalid date format. Please use Y-m-d or d-m-Y.'
          ], 422);
      }
  }
}
    $Effectivenessreports = Effectivenessreports::where('id', $id)->get();

    foreach ($Effectivenessreports as $report) {
      $report->update($data);
  }
    return response()->json([
        'status' => true,
        'message' => 'Updated report successfully',
        'data' => $Effectivenessreports,
        'pagination' => [
            'current_page' => 1,
            'total_pages' => 1,
            'total_items' => 1,
            'items_per_page' => 1,
        ],

    ], 200);
}
public function destroy($id)
{

    $charity = Auth::guard('api-charities')->user();
    if (!$charity) {
        return response()->json(['status'=>false,'message' => 'Unauthorized'], 401);
    }
    $charityId = $charity->id;


    // Find the financial report by ID and ensure it belongs to the authenticated charity
   $Effectivenessreports = Effectivenessreports::where('id', $id)->first();

    // Delete the financial report
    $Effectivenessreports->delete();

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
