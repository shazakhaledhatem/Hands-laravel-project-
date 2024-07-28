<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Charity;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VolunteerController extends Controller
{
  public function createVolunteerOrder(Request $request, $charityId)
  {
      $user = Auth::guard('api')->user(); // Authentication for API guard
      if (!$user) {
          return response()->json(['message' => 'Unauthorized'], 401);
      }

      $userId = $user->id;

      $existingOrder = Volunteer::where('users_id', $userId)
      ->where('charities_id', $charityId)
      ->first();

  if ($existingOrder) {
      return response()->json([
          'status' => false,
          'message' => 'You have already submitted an order to this charity.'
      ], 409); // Conflict status code
  }

      // Define the validation rules
      $validator = Validator::make($request->all(), [
          'full_name' => 'required|string|max:255',
          'mother_name' => 'required|string|max:255',
          'birth_place' => 'required|string|max:255',
          'birth_date' => 'required',
          'national_number' => 'required|string',
          'gender' => 'required|in:male,female',
          'marital_status' => 'required|in:single,married,divorced,widowed',
          'phone_number' => 'required|string',
          'address' => 'required|string|max:255',
          'nationality' => 'required|string|max:255',
          'mandatory_service' => 'required|string|max:255',
          'email' => 'required|email|max:255',
          'facebook' => 'nullable|string|max:255',
          'instagram' => 'nullable|string|max:255',
          'whatsapp' => 'nullable|string|max:255',
          'education' => 'required|string',
          'specilization' => 'nullable|string',
          'number_of_years' => 'nullable|integer',
          'education_rate' => 'nullable|string',
          'language_proficiency' => 'nullable|string',
          'work_experiences' => 'nullable|string',
          'training_courses' => 'nullable|string',
          'other_volunteering' => 'nullable|string',
          'hobbies' => 'nullable|string',
          'ambition' => 'nullable|string',
          'strengths' => 'nullable|string',
          'weaknesses' => 'nullable|string',
          'motivation_for_volunteering' => 'nullable|string',
          'why_charity' => 'required|string',
          'availability_for_volunteering' => 'required|string|max:255',
          'preferred_time' => 'required|string|max:255',
          'previous_experience' => 'nullable|boolean',
          'Developmental' => 'nullable|boolean',
          'Child_care' => 'nullable|boolean',
          'Training' => 'nullable|boolean',
          'Shelter_and_relief' => 'nullable|boolean',
          'Events_and_conferences' => 'nullable|boolean',
          'Awareness_campaigns' => 'nullable|boolean',
          'Elderly_care' => 'nullable|boolean',
          'Supporting_women' => 'nullable|boolean',
          'Maintenance_technician' => 'nullable|boolean',
          'field_media_photography' => 'nullable|boolean',
          'Administrative_field' => 'nullable|boolean',
      ]);

      // Check if the validation fails
      if ($validator->fails()) {
          return response()->json([
            'status'=>false,
            'errors' => $validator->errors()], 422);
      }

      $birth_date = null;
      try {
          $birth_date = Carbon::createFromFormat('Y-m-d', $request->birth_date)->format('Y-m-d');
      } catch (\Exception $e) {
          try {
              $birth_date = Carbon::createFromFormat('d-m-Y', $request->birth_date)->format('Y-m-d');
          } catch (\Exception $e) {
              return response()->json([
                  'status' => false,
                  'message' => 'Invalid birth date format'
              ], 422);
          }
      }


  // Create the volunteer order
      $volunteer = Volunteer::create([
          'charities_id' => $charityId,
          'full_name' => $request->full_name,
          'mother_name' => $request->mother_name,
          'birth_place' => $request->birth_place,
          'birth_date' => $birth_date,
          'national_number' => $request->national_number,
          'gender' => $request->gender,
          'marital_status' => $request->marital_status,
          'phone_number' => $request->phone_number,
          'address' => $request->address,
          'nationality' => $request->nationality,
          'mandatory_service' => $request->mandatory_service,
          'email' => $request->email,
          'facebook' => $request->facebook,
          'instagram' => $request->instagram,
          'whatsapp' => $request->whatsapp,
          'education' => $request->education,
          'specilization' => $request->specilization,
          'number_of_years' => $request->number_of_years,
          'education_rate' => $request->education_rate,
          'language_proficiency' => $request->language_proficiency,
          'work_experiences' => $request->work_experiences,
          'training_courses' => $request->training_courses,
          'other_volunteering' => $request->other_volunteering,
          'hobbies' => $request->hobbies,
          'ambition' => $request->ambition,
          'strengths' => $request->strengths,
          'weaknesses' => $request->weaknesses,
          'motivation_for_volunteering' => $request->motivation_for_volunteering,
          'why_charity' => $request->why_charity,
          'availability_for_volunteering' => $request->availability_for_volunteering,
          'preferred_time' => $request->preferred_time,
          'previous_experience' => $request->previous_experience,
          'Developmental' => $request->Developmental,
          'Child_care' => $request->Child_care,
          'Training' => $request->Training,
          'Shelter_and_relief' => $request->Shelter_and_relief,
          'Events_and_conferences' => $request->Events_and_conferences,
          'Awareness_campaigns' => $request->Awareness_campaigns,
          'Elderly_care' => $request->Elderly_care,
          'Supporting_women' => $request->Supporting_women,
          'Maintenance_technician' => $request->Maintenance_technician,
          'field_media_photography' => $request->field_media_photography,
          'Administrative_field' => $request->Administrative_field,
          'users_id' => $userId,
          'status' => "waiting", // default status
      ]);

      return response()->json([
          'status' => true,
          'message' => 'Volunteer order created successfully',
          'data' => [

              'volunteer' => $volunteer
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

  public function getcharityvolunteer(Request $request)
{
    // Get the authenticated user
    $user = Auth::guard('api')->user();
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $userId = $user->id;
    $volunteer = Volunteer::where('users_id', $userId)->get();

    // Extract charity IDs from the volunteer entries with 'accept' status
    $charityIds = [];
    foreach ($volunteer as $entry) {
        if ($entry->status == "accept") {
            $charityIds[] = $entry->charities_id;  // Ensure 'charities_id' is the correct field name
        }
    }

    // Get the unique charity IDs
    $charityIds = array_unique($charityIds);

    // Fetch the charity details with pagination
    $charities = Charity::whereIn('id', $charityIds)->paginate(10);

    // Prepare pagination data
    $pagination = [
        'current_page' => $charities->currentPage(),
        'total_pages' => $charities->lastPage(),
        'total_items' => $charities->total(),
        'items_per_page' => $charities->perPage(),
        'first_item' => $charities->firstItem(),
        'last_item' => $charities->lastItem(),
        'has_more_pages' => $charities->hasMorePages(),
        'next_page_url' => $charities->nextPageUrl(),
        'previous_page_url' => $charities->previousPageUrl(),
    ];

    // Return the charities in the response
    return response()->json([
        'status' => true,
        'message' => 'Volunteers charity fetched successfully',
        'data' => [
            'charities' => $charities->items()
        ],
        'pagination' => $pagination,
    ], 200);
}
public function joinEffectiveness(Request $request, $effectivenessId)
{





}




}
