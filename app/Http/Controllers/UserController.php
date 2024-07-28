<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use App\Models\LocationThatCoveredByCharities;
use App\Models\User;
use App\Models\Effectiveness;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\PersonalAccessToken;
use App\Models\Education;
use App\Models\Relief;
use App\Models\Health;
use App\Models\Life_hood ;
use App\Models\Orderesfromemergencystatus ;
use Carbon\Carbon;
use App\Models\Charity;


class UserController extends Controller
{




  public function createUser(Request $request)
{
  try {
      //Validated
      $validateUser = Validator::make($request->all(), [
          'firstName' => 'required',
          'lastName' => 'required',
          'phone' => 'required',
          'address' => 'required',
          'type' => 'required',
          'email' => 'required|email|unique:users,email',
          'password' => 'required'
      ]);

      if ($validateUser->fails()) {
          return response()->json([
              'status' => false,
              'message' => 'Validation error',
              'errors' => $validateUser->errors()
          ], 422);
      }

      $user = User::create([
          'firstName' => $request->firstName,
          'lastName' => $request->lastName,
          'phone' => $request->phone,
          'address' => $request->address,
          'type' => $request->type,
          'email' => $request->email,
          'password' => Hash::make($request->password)
      ]);

      // Fetch paginated list of users
      $users = User::paginate(10); // Adjust the pagination as needed

      $user->tokens()->delete();

  // Create a new token
  $token = $user->createToken('API TOKEN')->plainTextToken;

  // Store the latest token hash
  $user->latest_token = hash('sha256', $token);
  $user->save();
  $user=['token' => $token,'user' =>$user];
      return response()->json([
          'status' => true,
          'message' => 'User Created Successfully',
        //  'token' => $user->createToken("API TOKEN")->plainTextToken,
          'data' => $user,
          'pagination' => [
          'current_page' => $users->currentPage(),
          'total_pages' => $users->lastPage(),
          'total_items' => $users->total(),
          'items_per_page' => $users->perPage(),
          'first_item' => $users->firstItem(),
          'last_item' => $users->lastItem(),
          'has_more_pages' => $users->hasMorePages(),
          'next_page_url' => $users->nextPageUrl(),
          'previous_page_url' => $users->previousPageUrl(),
      ],
      ], 200);

  } catch (\Throwable $th) {
      return response()->json([
          'status' => false,
          'message' => $th->getMessage()
      ], 500);
  }
}

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
              'email' => 'required|email',
              'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 400);
            }

            $user = User::where('email', $request->email)->first();

            $users = User::paginate(10); // Adjust the pagination as needed
            $user->tokens()->delete();

        // Create a new token
        $token = $user->createToken('API TOKEN')->plainTextToken;

        // Store the latest token hash
        $user->latest_token = hash('sha256', $token);
        $user->save();
        $user=['token' => $token,'user' =>$user];
        //   $user=['token' => $user->createToken("API TOKEN")->plainTextToken,'user' =>$user];
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
            //   'token' => $user->createToken("API TOKEN")->plainTextToken,
                'data'=> $user,
                'pagination' => [
                'current_page' => $users->currentPage(),
                'total_pages' => $users->lastPage(),
                'total_items' => $users->total(),
                'items_per_page' => $users->perPage(),
                'first_item' => $users->firstItem(),
                'last_item' => $users->lastItem(),
                'has_more_pages' => $users->hasMorePages(),
                'next_page_url' => $users->nextPageUrl(),
                'previous_page_url' => $users->previousPageUrl(),
            ],

            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    //need auth
    public function indexhealth() {
      $user = Auth::guard('api')->user(); // Authentication for API guard
        if (!$user) {
            return response()->json(['status'=>false,'message' => 'Unauthorized'], 401);
        }

      //  $userid = $user->id;

      $health_charity_ids = DB::table('health_charities')->pluck('charities_id');

// Fetch all charities that match the retrieved IDs and paginate them
$charities = DB::table('charities')->whereIn('id', $health_charity_ids)->paginate(10);  // Adjust the pagination as needed

      // Log the output of the query
    //  \Log::debug('Charities data:', ['data' => $charities]);

      // Prepare the response data including pagination details
      return response()->json([
          'status' => true,
          'message' => 'Charities health data retrieved successfully',  // Updated message
          'data' => $charities->items(),  // Extracting items from paginator
          'pagination' => [
              'current_page' => $charities->currentPage(),
              'total_pages' => $charities->lastPage(),
              'total_items' => $charities->total(),
              'items_per_page' => $charities->perPage(),
              'first_item' => $charities->firstItem(),
              'last_item' => $charities->lastItem(),
              'has_more_pages' => $charities->hasMorePages(),
              'next_page_url' => $charities->nextPageUrl(),
              'previous_page_url' => $charities->previousPageUrl(),
          ],
      ], 200);
  }



  public function indexeducation() {
    $user = Auth::guard('api')->user(); // Authentication for API guard
      if (!$user) {
          return response()->json(['status'=>false,'message' => 'Unauthorized'], 401);
      }
    $education_charity_ids = DB::table('education_charities')->pluck('charities_id');

// Fetch all charities that match the retrieved IDs and paginate them
$charities = DB::table('charities')->whereIn('id', $education_charity_ids)->paginate(10);  // Adjust the pagination as needed

    // Log the output of the query
  //  \Log::debug('Charities data:', ['data' => $charities]);

    // Prepare the response data including pagination details
    return response()->json([
        'status' => true,
        'message' => 'Charities education data retrieved successfully',  // Updated message
        'data' => $charities->items(),  // Extracting items from paginator
        'pagination' => [
            'current_page' => $charities->currentPage(),
            'total_pages' => $charities->lastPage(),
            'total_items' => $charities->total(),
            'items_per_page' => $charities->perPage(),
            'first_item' => $charities->firstItem(),
            'last_item' => $charities->lastItem(),
            'has_more_pages' => $charities->hasMorePages(),
            'next_page_url' => $charities->nextPageUrl(),
            'previous_page_url' => $charities->previousPageUrl(),
        ],
    ], 200);
}



  public function indexrelief() {
    $user = Auth::guard('api')->user(); // Authentication for API guard
      if (!$user) {
          return response()->json(['status'=>false,'message' => 'Unauthorized'], 401);
      }
    $relief_charity_ids = DB::table('relief_charities')->pluck('charities_id');

// Fetch all charities that match the retrieved IDs and paginate them
$charities = DB::table('charities')->whereIn('id', $relief_charity_ids)->paginate(10);  // Adjust the pagination as needed

    // Log the output of the query
  //  \Log::debug('Charities data:', ['data' => $charities]);

    // Prepare the response data including pagination details
    return response()->json([
        'status' => true,
        'message' => 'Charities relief data retrieved successfully',  // Updated message
        'data' => $charities->items(),  // Extracting items from paginator
        'pagination' => [
            'current_page' => $charities->currentPage(),
            'total_pages' => $charities->lastPage(),
            'total_items' => $charities->total(),
            'items_per_page' => $charities->perPage(),
            'first_item' => $charities->firstItem(),
            'last_item' => $charities->lastItem(),
            'has_more_pages' => $charities->hasMorePages(),
            'next_page_url' => $charities->nextPageUrl(),
            'previous_page_url' => $charities->previousPageUrl(),
        ],
    ], 200);
}




  public function indexlifehood() {
    $user = Auth::guard('api')->user(); // Authentication for API guard
      if (!$user) {
          return response()->json(['status'=>false,'message' => 'Unauthorized'], 401);
      }
    $lifehood_charity_ids = DB::table('lifehood_charities')->pluck('charities_id');
// Fetch all charities that match the retrieved IDs and paginate them
$charities = DB::table('charities')->whereIn('id', $lifehood_charity_ids)->paginate(10);  // Adjust the pagination as needed

    // Log the output of the query
  //  \Log::debug('Charities data:', ['data' => $charities]);

    // Prepare the response data including pagination details
    return response()->json([
        'status' => true,
        'message' => 'Charities lifehood data retrieved successfully',  // Updated message
        'data' => $charities->items(),  // Extracting items from paginator
        'pagination' => [
            'current_page' => $charities->currentPage(),
            'total_pages' => $charities->lastPage(),
            'total_items' => $charities->total(),
            'items_per_page' => $charities->perPage(),
            'first_item' => $charities->firstItem(),
            'last_item' => $charities->lastItem(),
            'has_more_pages' => $charities->hasMorePages(),
            'next_page_url' => $charities->nextPageUrl(),
            'previous_page_url' => $charities->previousPageUrl(),
        ],
    ], 200);
}
  /*public function show($id)
{

  $charity = DB::table('charities')
      ->join('beneficiary__healths', 'beneficiaries.id', '=', 'beneficiary__healths.beneficiaries_id')
      ->join('healths', 'beneficiary__healths.healths_id', '=', 'healths.id')
      ->where('beneficiaries.users_id', $userId)
      ->select('beneficiaries.*','healths.*', 'beneficiary__healths.created_at as order_date')
      ->paginate($perPage);

    $charity = DB::table('charities')->where('id', $id)->first();
    $charity_target_people=DB::table('charity_target_people')->where('charities_id',$id);
    dd($charity_target_people);
    if (!$charity) {
        return response()->json([
            'status' => false,
            'message' => 'Charity not found',
            'data' => null,
            'pagination' => (object)[]
        ], 404);
      }
    return response()->json([
        'status' => true,
        'message' => 'Charity data retrieved successfully',
        'data' => $charity,
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
*/
//need auth
public function show(Request $request,$id) {
  /*$token = $request->header('Authorization');
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
      return response()->json([    'status' => false,'message' => 'Unauthorized'], 401);
  }

  // Validate that the token matches the latest token
  if ($user->latest_token !== $hashedToken) {
      return response()->json([    'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
  }

  // Check if the token has the required capability
  if (!$user->tokenCan('API TOKEN')) {
      return response()->json([    'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
  }

  // Get the user ID
  $userid = $user->id;
  $perPage = 10;*/


  $charities = DB::table('charities')
      ->leftJoin('charity_target_people', 'charities.id', '=', 'charity_target_people.charities_id')
      ->leftJoin('target_people', 'charity_target_people.target_people_id', '=', 'target_people.id')
      ->leftJoin('location_that_covered_by_charities', 'charities.id', '=', 'location_that_covered_by_charities.charities_id')
      /*
      ->leftJoin('health_charities', 'charities.id', '=', 'health_charities.charities_id')
      ->leftJoin('education_charities', 'charities.id', '=', 'education_charities.charities_id')
      ->leftJoin('relief_charities', 'charities.id', '=', 'relief_charities.charities_id')
      ->leftJoin('lifehood_charities', 'charities.id', '=', 'lifehood_charities.charities_id')
      */
      ->select(
          'charities.*',
          'target_people.*',
          'charity_target_people.*',
          'location_that_covered_by_charities.*'
          /*
          'health_charities.description as health_description',
          'education_charities.description as education_description',
          'relief_charities.description as relief_description',
          'lifehood_charities.description as lifehood_description'
          */
      )
      ->where('charities.id', $id)
      ->first();

  //dd($charities);

      // Retrieve education details
       $education_charities = DB::table('education_charities')
           ->where('charities_id', $id)
           ->pluck('education_id');

       $education = Education::whereIn('id', $education_charities)->get();

       // Retrieve health details
       $health_charities = DB::table('health_charities')
           ->where('charities_id', $id)
           ->pluck('healths_id');

       $health = Health::whereIn('id', $health_charities)->get();

       // Retrieve relief details
       $relief_charities = DB::table('relief_charities')
           ->where('charities_id', $id)
           ->pluck('reliefs_id');

       $relief = Relief::whereIn('id', $relief_charities)->get();

       // Retrieve lifehood details
   $lifehood_charities = DB::table('lifehood_charities')
       ->where('charities_id', $id)
       ->pluck('life_hoods_id'); // Assuming the correct column is 'lifehood_id'

   $lifehood = Life_hood::whereIn('id', $lifehood_charities)->get();


        $effectiveness = DB::table('effectivenesses')
      ->join('location_that_covered_by_charities', 'effectivenesses.location_that_covered_by_charities_id', '=', 'location_that_covered_by_charities.id')
      ->select(
          'effectivenesses.*',
          'location_that_covered_by_charities.*'
      )
      ->where('effectivenesses.charities_id', $id) // Assuming you want to filter by the charity ID
      ->get();


    return response()->json([
        'status' => true,
        'message' => 'Successfully retrieved all charity details with pagination.',
        'data' => [

          'charity'=>$charities,
        'education' => $education,
           'health' => $health,
           'relief' => $relief,
           'lifehood' => $lifehood,
        'effectivness'=>$effectiveness,
      'charityId'=>$id],
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
public function getUserOrders(Request $request) {
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
            return response()->json([    'status' => false,'message' => 'Unauthorized'], 401);
        }

        // Validate that the token matches the latest token
        if ($user->latest_token !== $hashedToken) {
            return response()->json([    'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
        }

        // Check if the token has the required capability
        if (!$user->tokenCan('API TOKEN')) {
            return response()->json([    'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
        }

        // Get the user ID
        $userid = $user->id;
    $perPage = 10; // You can adjust this number based on your needs or make it a parameter

    // Fetch orders related to health
    $healthOrders = DB::table('beneficiaries')
        ->join('beneficiary__healths', 'beneficiaries.id', '=', 'beneficiary__healths.beneficiaries_id')
        ->join('healths', 'beneficiary__healths.healths_id', '=', 'healths.id')
          ->leftJoin('charities', 'beneficiary__healths.charities_id', '=', 'charities.id')
        ->where('beneficiaries.users_id', $userid)
        ->select('beneficiaries.*','healths.*', 'beneficiary__healths.*', 'charities.name as charity_name')
        ->paginate($perPage);



    // Fetch orders related to education
    $educationOrders = DB::table('beneficiaries')
        ->join('beneficiary__education', 'beneficiaries.id', '=', 'beneficiary__education.beneficiaries_id')
        ->join('education', 'beneficiary__education.education_id', '=', 'education.id')
        ->leftJoin('charities', 'beneficiary__education.charities_id', '=', 'charities.id')
        ->where('beneficiaries.users_id', $userid)
        ->select('beneficiaries.*','education.*', 'beneficiary__education.*', 'charities.name as charity_name')
        ->paginate($perPage);

    // Fetch orders related to livelihood
    $livelihoodOrders = DB::table('beneficiaries')
        ->join('beneficiary__lifehoods', 'beneficiaries.id', '=', 'beneficiary__lifehoods.beneficiaries_id')
        ->join('life_hoods', 'beneficiary__lifehoods.lifehoods_id', '=', 'life_hoods.id')
          ->leftJoin('charities', 'beneficiary__lifehoods.charities_id', '=', 'charities.id')
        ->where('beneficiaries.users_id', $userid)
        ->select('beneficiaries.*','life_hoods.*', 'beneficiary__lifehoods.*', 'charities.name as charity_name')
        ->paginate($perPage);

    // Fetch orders related to relief
    $reliefOrders = DB::table('beneficiaries')
        ->join('beneficiary__reliefs', 'beneficiaries.id', '=', 'beneficiary__reliefs.beneficiaries_id')
        ->join('reliefs', 'beneficiary__reliefs.reliefs_id', '=', 'reliefs.id')
          ->leftJoin('charities', 'beneficiary__reliefs.charities_id', '=', 'charities.id')
        ->where('beneficiaries.users_id', $userid)
        ->select('beneficiaries.*','reliefs.*', 'beneficiary__reliefs.*', 'charities.name as charity_name')
        ->paginate($perPage);



  // $emergencyorder = DB::table('orderesfromemergencystatuses')
  //   ->leftJoin('charities', 'orderesfromemergencystatuses.charities_id', '=', 'charities.id')
  //   ->where('orderesfromemergencystatuses.user_id', $userid)
  //   ->select('orderesfromemergencystatuses.*','charities.name as charity_name')
  //   ->paginate($perPage);

  $emergencyOrder = Orderesfromemergencystatus::leftJoin('charities', 'orderesfromemergencystatuses.charities_id', '=', 'charities.id')
      ->where('orderesfromemergencystatuses.user_id', $userid)
      ->select('orderesfromemergencystatuses.*','charities.name as charity_name')
      ->paginate($perPage);




    // Consolidate all orders into a single response object
    return response()->json([
        'status' => true,
        'message' => 'Successfully retrieved all orders across categories.',
        'data' => [
            'health' => $healthOrders,
            'education' => $educationOrders,
            'lifehood' => $livelihoodOrders,
            'relief' => $reliefOrders,
            'emergencyorder'=>$emergencyOrder,
        ],
    ], 200);
}


 public function updateprofile(Request $request){
   $user = Auth::guard('api')->user(); // Assuming you have a user method returning the charity
    if (!$user) {
        return response()->json([    'status' => false,'message' => 'Unauthorized'], 401);
    }

   $userid =$user->id;


    // Update email if provided
    if ($request->has('email')) {
        $user->email = $request->email;
    }

    // Update phone if provided
    if ($request->has('phone')) {
        $user->phone = $request->phone;
    }

    // Update password if provided and hash it
    if ($request->has('address')) {
        $user->address = $request->address;
    }

    // Save the changes to the user
    $user->save();
    //  $user->save();
    return response()->json([
        'status' => true,
        'message' => 'your profile information updaeted successfully',
        'data' => $user,
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
