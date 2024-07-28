<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Health;
use App\Models\Beneficiary_Health;
use App\Models\Education;
use App\Models\Beneficiary_Education;
use App\Models\Relief;
use App\Models\Beneficiary_Relief;
use App\Models\Life_hood;
use App\Models\Beneficiary_Lifehood;
use App\Models\health_charities;
use Auth;
use Illuminate\Support\Facades\Validator;
class BeneficiaryController extends Controller
{

  public function beneficiaryorderfromhealthsection(Request $request) {
      $user = Auth::guard('api')->user();
      if (!$user) {
          return response()->json(['message' => 'Unauthorized'], 401);
      }

      $validator = Validator::make($request->all(), [
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'birth_date' => 'required',
          'address' => 'required|string|max:255',
          'phone' => 'required|string|max:15',
          'Discription' => 'nullable|string',
          'typeofdisease' => 'required|string|max:255',
          'operation' => 'nullable|boolean',
          'doctorcheck' => 'nullable|boolean',
          'medicine' => 'nullable|boolean',
          'medicaldevice' => 'nullable|boolean',
          'typeofdevice' => 'nullable|string|max:255',
          'milkanddiaper' => 'nullable|boolean',
      ]);

      if ($validator->fails()) {
          return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
      }

      $userid = $user->id;

  /*    $userHealthRecords = Health::whereHas('beneficiaries', function ($query) use ($userid) {
        $query->where('users_id', $userid);
    })->get();

    // Check if any of the user's health records match the new order's criteria
    foreach ($userHealthRecords as $health) {
        if ($health->typeofdisease == $request->typeofdisease &&
            $health->operation == $request->operation &&
            $health->doctorcheck == $request->doctorcheck &&
            $health->medicine == $request->medicine &&
            $health->medicaldevice == $request->medicaldevice &&
            $health->typeofdevice == $request->typeofdevice &&
            $health->milkanddiaper == $request->milkanddiaper) {
            return response()->json(['message' => 'You have already made a similar order.'], 409);
        }
    }*/



      try {
          DB::beginTransaction();

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
          $beneficiary = Beneficiary::create([
              'first_name' => $request->input('first_name'),
              'last_name' => $request->input('last_name'),
              'birth_date' => $birth_date,
              'address' => $request->input('address'),
              'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
              'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
              'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
              'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
              'orphans' => $request->input('orphans', false),
              'injured' => $request->input('injured', false),
              'users_id' => $userid,
              'displacedpeople' => $request->input('displacedpeople', false),
              'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
              'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
              'phone' => $request->input('phone'),
              'Discription' => $request->input('Discription')
          ]);

          $health = Health::create([
              'typeofdisease' => $request->input('typeofdisease'),
              'operation' => $request->input('operation', false),
              'doctorcheck' => $request->input('doctorcheck', false),
              'medicine' => $request->input('medicine', false),
              'medicaldevice' => $request->input('medicaldevice', false),
              'typeofdevice' => $request->input('typeofdevice'),
              'milkanddiaper' => $request->input('milkanddiaper', false)
          ]);

          $beneficiary_health = Beneficiary_Health::create([
              'beneficiaries_id' => $beneficiary->id,
              'healths_id' => $health->id,
              'charities_id' => NULL
          ]);

          $paginatedBeneficiaries = Beneficiary::latest()->paginate(10);

          DB::commit();
          return response()->json([
              'status' => true,
              'message' => 'You requested a health order successfully',
              'data' => [$beneficiary, $beneficiary_health, $health],
              'pagination' => [
                  'current_page' => $paginatedBeneficiaries->currentPage(),
                  'total_pages' => $paginatedBeneficiaries->lastPage(),
                  'total_items' => $paginatedBeneficiaries->total(),
                  'items_per_page' => $paginatedBeneficiaries->perPage(),
                  'first_item' => $paginatedBeneficiaries->firstItem(),
                  'last_item' => $paginatedBeneficiaries->lastItem(),
                  'has_more_pages' => $paginatedBeneficiaries->hasMorePages(),
                  'next_page_url' => $paginatedBeneficiaries->nextPageUrl(),
                  'previous_page_url' => $paginatedBeneficiaries->previousPageUrl(),
              ],
          ], 201);
      } catch (\Exception $e) {
          DB::rollback();
          return response()->json([
                'status' => false,
            'message' => 'Error processing your request: ' . $e->getMessage()], 500);
      }
  }

//التاكد من قصة المرض
   public function beneficiaryorderfromhealthcharity(Request $request, $id) {
    // Check if user is logged in
    $user = Auth::guard(  'api')->user(); // Assuming you have a user method returning the charity
     if (!$user) {
         return response()->json([
           'status'=>false,
           'message' => 'Unauthorized'], 401);
     }
     $validator = Validator::make($request->all(), [
             'first_name' => 'required|string|max:255',
             'last_name' => 'required|string|max:255',
             'birth_date' => 'required',
             'address' => 'required|string|max:255',
             'phone' => 'required|string|max:15',
             'Discription' => 'nullable|string',
             'typeofdisease' => 'required|string|max:255',
             'operation' => 'nullable|boolean',
             'doctorcheck' => 'nullable|boolean',
             'medicine' => 'nullable|boolean',
             'medicaldevice' => 'nullable|boolean',
             'typeofdevice' => 'nullable|string|max:255',
             'milkanddiaper' => 'nullable|boolean',

         ]);

         if ($validator->fails()) {
             return response()->json([
                'status'=>false,
               'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
         }

    $userid =$user->id;

    $charityHealth = health_charities::where('charities_id', $id)->first();

    if (!$charityHealth) {
        // Handle case where no matching record is found
        return response()->json(['message' => 'Health charity record not found'], 404);
    }

    $healthId = $charityHealth->healths_id;
 $healthch=Health::where('id',  $healthId)->first();

       // if (
       //     ($request->typeofdisease != $healthch->typeofdisease) ||
       //     ($request->operation != $healthch->operation) ||
       //     ($request->doctorcheck != $healthch->doctorcheck) ||
       //     ($request->medicine != $healthch->medicine) ||
       //     ($request->medicaldevice != $healthch->medicaldevice) ||
       //     ($request->typeofdevice != $healthch->typeofdevice ) ||
       //     ($request->milkanddiaper  != $healthch->milkanddiaper)
       // ) {
       //     return response()->json([
       //       'status'=>false,
       //       'message' => 'This charity cannot help with the specified health issue'], 400);
       // }

       try {
           DB::beginTransaction();

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
           $beneficiary = Beneficiary::create([
               'first_name' => $request->input('first_name'),
               'last_name' => $request->input('last_name'),
               'birth_date' => $birth_date,  // default to false if not provided

               'address' => $request->input('address'),
               'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
               'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
               'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
               'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
               'orphans' => $request->input('orphans', false),
               'injured' => $request->input('injured', false),
               'users_id' =>  $userid,  // This will set users_id to the id of the logged-in user
               'displacedpeople' => $request->input('displacedpeople', false),
               'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
               'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
               'phone' => $request->input('phone'),
               'Discription' => $request->input('Discription')
           ]);
//dd($beneficiaries_id);
$health=Health::create([
  'typeofdisease' => $request->input('typeofdisease'),
  'operation'=> $request->input('operation', false),
  'doctorcheck'=> $request->input('doctorcheck', false),
  'medicine'=> $request->input('medicine', false),
  'medicaldevice'=> $request->input('medicaldevice', false),
  'typeofdevice'=> $request->input('typeofdevice'),
  'milkanddiaper'=> $request->input('milkanddiaper', false)
]);

$beneficiary__health=Beneficiary_Health::create([
  'beneficiaries_id' => $beneficiary->id,
      'healths_id' => $health->id,
      'charities_id' => $id,

]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
        DB::commit();
        return response()->json([
          'status'=>true,
                  'message' => 'you request a health order successfully',
                   'data' => [$beneficiary,$beneficiary__health,$health],
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
               ], 201);    }
                catch (\Exception $e) {
        DB::rollback();
        return response()->json([
              'status' => false,
          'message' => 'Error processing your request: ' . $e->getMessage()], 500);
    }
}








public function beneficiaryorderfromeducationsection(Request $request) {
  $user = Auth::guard(  'api')->user(); // Assuming you have a user method returning the charity
   if (!$user) {
       return response()->json(['message' => 'Unauthorized'], 401);
   }

  $userid =$user->id;
  $validator = Validator::make($request->all(), [
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'birth_date' => 'required',
          'address' => 'required|string|max:255',
          'phone' => 'required|string|max:15',
          'Discription' => 'nullable|string',
          'typeofeducation' => 'required|string|max:255',
          'clothes' => 'nullable|boolean',
          'booksandpens' => 'nullable|boolean',
          'courses' => 'nullable|boolean',
          'bags' => 'nullable|boolean',


      ]);

      if ($validator->fails()) {
          return response()->json([
            'status'=>false,
            'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
      }
/*
$existingEducation = Education::where('typeofeducation', $request->typeofeducation)
       ->where('clothes', $request->clothes)
       ->where('booksandpens', $request->booksandpens)
       ->where('courses', $request->courses)
       ->where('bags', $request->bags)
       ->first();
       if ($existingEducation&&$user) {

           DB::commit();  // Assuming you might have other operations before that need committing
           return response()->json(['message' => 'You have already made a similar order.'], 409);
       }
*/

try {
    DB::beginTransaction();

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
    $beneficiary = Beneficiary::create([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'birth_date' => $birth_date,  // default to false if not provided

        'address' => $request->input('address'),
        'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
        'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
        'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
        'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
        'orphans' => $request->input('orphans', false),
        'injured' => $request->input('injured', false),
        'users_id' =>  $userid,  // This will set users_id to the id of the logged-in user
        'displacedpeople' => $request->input('displacedpeople', false),
        'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
        'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
        'phone' => $request->input('phone'),
        'Discription' => $request->input('Discription')
    ]);

       $education=Education::create([
       'typeofeducation' => $request->input('typeofeducation'),
       'clothes'=> $request->input('clothes', false),
       'booksandpens'=> $request->input('booksandpens', false),
       'courses'=> $request->input('courses', false),
       'bags'=> $request->input('bags', false)

       ]);
$beneficiary__education=Beneficiary_Education::create([
'beneficiaries_id' => $beneficiary->id,
   'education_id' => $education->id,
   'charities_id' => NULL,

]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
     DB::commit();
     return response()->json([
       'status'=>true,
                'message' => 'you request a education order successfully',
                   'data' => [$beneficiary,$beneficiary__education,$education],
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
            ], 201);    }
             catch (\Exception $e) {
     DB::rollback();
     return response()->json([
           'status' => false,
       'message' => 'Error processing your request: ' . $e->getMessage()], 500);
 }
}


//لم يتم وضع نفس لشرط الي بالهيلث
public function beneficiaryorderfromeducationcharity(Request $request, $id) {
  $user = Auth::guard(  'api')->user(); // Assuming you have a user method returning the charity
   if (!$user) {
       return response()->json(['status'=>false,
         'message' => 'Unauthorized'], 401);
   }

   $validator = Validator::make($request->all(), [
           'first_name' => 'required|string|max:255',
           'last_name' => 'required|string|max:255',
           'birth_date' => 'required',
           'address' => 'required|string|max:255',
           'phone' => 'required|string|max:15',
           'Discription' => 'nullable|string',
           'typeofeducation' => 'required|string|max:255',
           'clothes' => 'nullable|boolean',
           'booksandpens' => 'nullable|boolean',
           'courses' => 'nullable|boolean',
           'bags' => 'nullable|boolean',


       ]);

       if ($validator->fails()) {
           return response()->json(['status'=>false,
             'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
       }


  $userid =$user->id;

/*
$existingEducation = Education::where('typeofeducation', $request->typeofeducation)
       ->where('clothes', $request->clothes)
       ->where('booksandpens', $request->booksandpens)
       ->where('courses', $request->courses)
       ->where('bags', $request->bags)
       ->first();
       if ($existingEducation&&$user) {

           DB::commit();  // Assuming you might have other operations before that need committing
           return response()->json(['message' => 'You have already made a similar order.'], 409);
       }
*/


try {
    DB::beginTransaction();

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
    $beneficiary = Beneficiary::create([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'birth_date' => $birth_date,  // default to false if not provided

        'address' => $request->input('address'),
        'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
        'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
        'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
        'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
        'orphans' => $request->input('orphans', false),
        'injured' => $request->input('injured', false),
        'users_id' =>  $userid,  // This will set users_id to the id of the logged-in user
        'displacedpeople' => $request->input('displacedpeople', false),
        'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
        'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
        'phone' => $request->input('phone'),
        'Discription' => $request->input('Discription')
    ]);
       $education=Education::create([
       'typeofeducation' => $request->input('typeofeducation'),
       'clothes'=> $request->input('clothes', false),
       'booksandpens'=> $request->input('booksandpens', false),
       'courses'=> $request->input('courses', false),
       'bags'=> $request->input('bags', false)

       ]);

$beneficiary__education=Beneficiary_Education::create([
'beneficiaries_id' => $beneficiary->id,
   'education_id' => $education->id,
   'charities_id' => $id,

]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
     DB::commit();
     return response()->json([
       'status'=>true,
                'message' => 'you request a education order successfully',
                   'data' => [$beneficiary,$beneficiary__education,$education],
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
            ], 201);    }
             catch (\Exception $e) {
     DB::rollback();
     return response()->json([
           'status' => false,
       'message' => 'Error processing your request: ' . $e->getMessage()], 500);
 }
}





public function beneficiaryorderfromreliefsection(Request $request) {
  $user = Auth::guard(  'api')->user();
   if (!$user) {
       return response()->json([
             'status' => false,
         'message' => 'Unauthorized'], 401);
   }


   $validator = Validator::make($request->all(), [
           'first_name' => 'required|string|max:255',
           'last_name' => 'required|string|max:255',
           'birth_date' => 'required',
           'address' => 'required|string|max:255',
           'phone' => 'required|string|max:15',
           'Discription' => 'nullable|string',
           'home' => 'nullable|boolean',
           'housefurniture' => 'nullable|boolean',
           'food' => 'nullable|boolean',
           'clothes' => 'nullable|boolean',
           'money' => 'nullable|boolean',
           'psychologicalaid' => 'nullable|boolean',

       ]);

       if ($validator->fails()) {
           return response()->json([
                 'status' => false,
             'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
       }


  $userid =$user->id;

/*
$existingRelief = Relief::where('home', $request->home)
       ->where('housefurniture', $request->housefurniture)
       ->where('food', $request->food)
       ->where('clothes', $request->clothes)
       ->where('money', $request->money)
       ->where('psychologicalaid', $request->psychologicalaid)
       ->first();
       if ($existingRelief&&$user) {

           DB::commit();  // Assuming you might have other operations before that need committing
           return response()->json([
                 'status' => false,
             'message' => 'You have already made a similar order.'], 409);
       }*/
       try {
           DB::beginTransaction();

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

           $beneficiary = Beneficiary::create([
               'first_name' => $request->input('first_name'),
               'last_name' => $request->input('last_name'),
               'birth_date' => $birth_date,  // default to false if not provided

               'address' => $request->input('address'),
               'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
               'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
               'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
               'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
               'orphans' => $request->input('orphans', false),
               'injured' => $request->input('injured', false),
               'users_id' =>  $userid,  // This will set users_id to the id of the logged-in user
               'displacedpeople' => $request->input('displacedpeople', false),
               'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
               'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
               'phone' => $request->input('phone'),
               'Discription' => $request->input('Discription')
           ]);
       $relief=Relief::create([
       'home' => $request->input('home', false),
       'housefurniture'=> $request->input('housefurniture', false),
       'food'=> $request->input('food', false),
       'clothes'=> $request->input('clothes', false),
       'money'=> $request->input('money', false),
       'psychologicalaid'=> $request->input('psychologicalaid', false)
       ]);
$beneficiary__relief=Beneficiary_Relief::create([
'beneficiaries_id' => $beneficiary->id,
   'reliefs_id' => $relief->id,
   'charities_id' => NULL,

]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
     DB::commit();
     return response()->json([
       'status'=>true,
                'message' => 'you request a relief order successfully',
                   'data' => [$beneficiary,$beneficiary__relief,$relief],
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
            ], 201);    }
             catch (\Exception $e) {
     DB::rollback();
     return response()->json([
           'status' => false,
       'message' => 'Error processing your request: ' . $e->getMessage()], 500);
 }
}
//لم يتم وضع الشروط تبع انو يطلب من نفس الي بيخدم الجمعية
public function beneficiaryorderfromreliefcharity(Request $request, $id) {
  $user = Auth::guard(  'api')->user(); // Assuming you have a user method returning the charity
   if (!$user) {
       return response()->json([
             'status' => false,
         'message' => 'Unauthorized'], 401);
   }
   $validator = Validator::make($request->all(), [
           'first_name' => 'required|string|max:255',
           'last_name' => 'required|string|max:255',
           'birth_date' => 'required',
           'address' => 'required|string|max:255',
           'phone' => 'required|string|max:15',
           'Discription' => 'nullable|string',
           'home' => 'nullable|boolean',
           'housefurniture' => 'nullable|boolean',
           'food' => 'nullable|boolean',
           'clothes' => 'nullable|boolean',
           'money' => 'nullable|boolean',
           'psychologicalaid' => 'nullable|boolean',

       ]);

       if ($validator->fails()) {
           return response()->json([
                 'status' => false,
             'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
       }

  $userid =$user->id;
/*
$existingRelief = Relief::where('home', $request->home)
       ->where('housefurniture', $request->housefurniture)
       ->where('food', $request->food)
       ->where('clothes', $request->clothes)
       ->where('money', $request->money)
       ->where('psychologicalaid', $request->psychologicalaid)
       ->first();
       if ($existingRelief&&$user) {

           DB::commit();  // Assuming you might have other operations before that need committing
           return response()->json([
                 'status' => false,
             'message' => 'You have already made a similar order.'], 409);
       }*/

       try {
           DB::beginTransaction();

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

           $beneficiary = Beneficiary::create([
               'first_name' => $request->input('first_name'),
               'last_name' => $request->input('last_name'),
               'birth_date' => $birth_date,  // default to false if not provided

               'address' => $request->input('address'),
               'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
               'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
               'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
               'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
               'orphans' => $request->input('orphans', false),
               'injured' => $request->input('injured', false),
               'users_id' =>  $userid,  // This will set users_id to the id of the logged-in user
               'displacedpeople' => $request->input('displacedpeople', false),
               'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
               'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
               'phone' => $request->input('phone'),
               'Discription' => $request->input('Discription')
           ]);


       $relief=Relief::create([
       'home' => $request->input('home', false),
       'housefurniture'=> $request->input('housefurniture', false),
       'food'=> $request->input('food', false),
       'clothes'=> $request->input('clothes', false),
       'money'=> $request->input('money', false),
       'psychologicalaid'=> $request->input('psychologicalaid', false)
       ]);
$beneficiary__relief=Beneficiary_Relief::create([
'beneficiaries_id' => $beneficiary->id,
   'reliefs_id' => $relief->id,
   'charities_id' => $id,

]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
     DB::commit();
     return response()->json([
       'status'=>true,
                'message' => 'you request a relief order successfully',
                   'data' => [$beneficiary,$beneficiary__relief,$relief],
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
            ], 201);    }
             catch (\Exception $e) {
     DB::rollback();
     return response()->json([
           'status' => false,
       'message' => 'Error processing your request: ' . $e->getMessage()], 500);
 }
}

public function beneficiaryorderfromlifehoodsection(Request $request) {
    $user = Auth::guard('api')->user(); // Assuming you have a user method returning the charity

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'birth_date' => 'required',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'Discription' => 'nullable|string',
        'learningaprofession' => 'nullable|boolean',
        'gainmoreexperienceinspecificfield' => 'nullable|boolean',
        'typeofworkthatyouwanttogain' => 'nullable|string',
        'jobapportunity' => 'nullable|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $userid = $user->id;
/*
    $existingLifeHood = Life_hood::where('learningaprofession', $request->learningaprofession)
        ->where('gainmoreexperienceinspecificfield', $request->gainmoreexperienceinspecificfield)
        ->where('typeofworkthatyouwanttogain', $request->typeofworkthatyouwanttogain)
        ->where('jobapportunity', $request->jobapportunity)
        ->first();

    if ($existingLifeHood) {
        return response()->json([
            'status' => false,
            'message' => 'You have already made a similar order.'
        ], 409);
    }*/

    try {
        DB::beginTransaction();

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

        $beneficiary = Beneficiary::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'birth_date' => $birth_date,
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'Discription' => $request->input('Discription'),
            'users_id' => $userid,
            'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
            'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
            'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
            'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
            'orphans' => $request->input('orphans', false),
            'injured' => $request->input('injured', false),
            'displacedpeople' => $request->input('displacedpeople', false),
            'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
            'numberofdiablechildern' => $request->input('numberofdiablechildern', 0)
        ]);

        $lifehood = Life_hood::create([
            'learningaprofession' => $request->input('learningaprofession', false),
            'gainmoreexperienceinspecificfield' => $request->input('gainmoreexperienceinspecificfield', false),
            'typeofworkthatyouwanttogain' => $request->input('typeofworkthatyouwanttogain'),
            'jobapportunity' => $request->input('jobapportunity', false)
        ]);

        $beneficiary_lifehood = Beneficiary_Lifehood::create([
            'beneficiaries_id' => $beneficiary->id,
            'lifehoods_id' => $lifehood->id,
            'charities_id' => null,
        ]);

$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Your lifehood order request was successful.',
            'data' => [$beneficiary, $beneficiary_lifehood, $lifehood],
            'pagination' => [
                'current_page' => $paginatedBeneficiaries->currentPage(),
                'total_pages' => $paginatedBeneficiaries->lastPage(),
                'total_items' => $paginatedBeneficiaries->total(),
                'items_per_page' => $paginatedBeneficiaries->perPage(),
                'first_item' => $paginatedBeneficiaries->firstItem(),
                'last_item' => $paginatedBeneficiaries->lastItem(),
                'has_more_pages' => $paginatedBeneficiaries->hasMorePages(),
                'next_page_url' => $paginatedBeneficiaries->nextPageUrl(),
                'previous_page_url' => $paginatedBeneficiaries->previousPageUrl(),
            ],
        ], 201);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'status' => false,
            'message' => 'Error processing your request: ' . $e->getMessage()
        ], 500);
    }
}
public function beneficiaryorderfromlifehoodcharity(Request $request, $id) {
  $user = Auth::guard(  'api')->user(); // Assuming you have a user method returning the charity
   if (!$user) {
       return response()->json([
         'status'=>false,
         'message' => 'Unauthorized'], 401);
   }
   $validator = Validator::make($request->all(), [
           'first_name' => 'required|string|max:255',
           'last_name' => 'required|string|max:255',
           'birth_date' => 'required',
           'address' => 'required|string|max:255',
           'phone' => 'required|string|max:15',
           'Discription' => 'nullable|string',
           'learningaprofession' => 'nullable|boolean',
           'gainmoreexperienceinspecificfield' => 'nullable|boolean',
           'typeofworkthatyouwanttogain' =>  'nullable|string',
           'jobapportunity' => 'nullable|boolean',


       ]);

       if ($validator->fails()) {
           return response()->json([
                 'status' => false,
             'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
       }
  $userid =$user->id;

 try {
     DB::beginTransaction();



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


/*
$existingLifeHood = Life_hood::where('learningaprofession', $request->learningaprofession)
       ->where('gainmoreexperienceinspecificfield', $request->gainmoreexperienceinspecificfield)
       ->where('typeofworkthatyouwanttogain', $request->typeofworkthatyouwanttogain)
       ->where('jobapportunity', $request->jobapportunity)
       ->first();

  if ($existingLifeHood&&$user) {

      DB::commit();  // Assuming you might have other operations before that need committing
      return response()->json(['message' => 'You have already made a similar order.'], 409);
  }*/
  //$birth_date = Carbon::createFromFormat('d-m-Y', $request->birth_date)->format('Y-m-d');

  $beneficiary = Beneficiary::create([
      'first_name' => $request->input('first_name'),
      'last_name' => $request->input('last_name'),
      'birth_date' => $birth_date,  // default to false if not provided

      'address' => $request->input('address'),
      'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
      'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
      'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
      'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
      'orphans' => $request->input('orphans', false),
      'injured' => $request->input('injured', false),
      'users_id' =>  $userid,  // This will set users_id to the id of the logged-in user
      'displacedpeople' => $request->input('displacedpeople', false),
      'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
      'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
      'phone' => $request->input('phone'),
      'Discription' => $request->input('Discription')
  ]);
  $lifehood=Life_hood::create([
  'learningaprofession' => $request->input('learningaprofession', false),
  'gainmoreexperienceinspecificfield'=> $request->input('gainmoreexperienceinspecificfield', false),
  'typeofworkthatyouwanttogain'=> $request->input('typeofworkthatyouwanttogain'),
  'jobapportunity'=> $request->input('jobapportunity', false)

  ]);

$beneficiary__lifehood=Beneficiary_Lifehood::create([
'beneficiaries_id' => $beneficiary->id,
   'lifehoods_id' => $lifehood->id,
   'charities_id' => $id,

]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
     DB::commit();
     return response()->json([
       'status'=>true,
                'message' => 'you request a lifehood order successfully',
                   'data' => [$beneficiary,$beneficiary__lifehood,$lifehood],
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
            ], 201);    }
             catch (\Exception $e) {
     DB::rollback();
     return response()->json([    'status' => false,
       'message' => 'Error processing your request: ' . $e->getMessage()], 500);
 }
}

}
