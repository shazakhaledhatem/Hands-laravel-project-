<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\EmeregencyStatus;
use App\Models\admin_active_emergency;
use App\Models\Factrsofemergencystatus;
use App\Models\Charity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\LocationThatCoveredByCharities;
use App\Models\User;
use App\Models\Effectiveness;

use Illuminate\Support\Facades\Hash;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\PersonalAccessToken;
use App\Models\Education;
use App\Models\Relief;
use App\Models\Health;
use App\Models\Life_hood ;
use App\Models\Orderesfromemergencystatus ;
use Carbon\Carbon;

class AdminActiveEmergencyController extends Controller
{
  public function browse_charity(){
    $charity=Charity::all();
  //  dd(  $charity);
      return view('Admin.pages.charity.show_charities',compact('charity'));
  }
  public function index(){
  return view('Admin.pages.forms.basic_elements');
  }
  public function index_factor(){
      $emergency_active=EmeregencyStatus::all();


  return view('Admin.pages.forms.factor_emergency',compact('emergency_active'));
  }
  public function put_factor(Request $request){

      $emergency_active=Factrsofemergencystatus::create([
        'type'=>$request->need,
         'emergencystatus_id'=>$request->emergency_type
      ]);

 return redirect()->back();
  //return view('Admin.pages.forms.factor_emergency',compact('emergency_active'));
  }

  public function get_emergency(){
    $charity = EmeregencyStatus::where('active',1)->with('factors')->get();

        return view('Admin.pages.forms.show_emergency', compact('charity'));
  //return view('Admin.pages.forms.factor_emergency',compact('emergency_active'));
  }

  public function show($id) {


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
        // dd([
        //     'charity' => $charities,
        //     'education' => $education,
        //     'health' => $health,
        //     'relief' => $relief,
        //     'lifehood' => $lifehood,
        //     'effectiveness' => $effectiveness
        // ]);
        return view('Admin.pages.charity.show_charities_detail', [

                      'charities'=>$charities,
                    'education' => $education,
                       'health' => $health,
                       'relief' => $relief,
                       'lifehood' => $lifehood,
                    'effectivness'=>$effectiveness,

        ]);




  }


  public function unableemergency($id){
    $emergencyStatus = EmeregencyStatus::find($id);

    // Check if the emergency status exists
    if ($emergencyStatus) {
        // Set the active status to 0 (deactivate)
        $emergencyStatus->active = 0;

        // Save the changes to the database
        $emergencyStatus->save();
    }

    // Redirect back to the previous page
    return redirect()->back();

  }






  public function active_emergency_status(Request $request){
    $validator = Validator::make($request->all(), [
      'type' => 'required|string|max:255',
  ]);
  if ($validator->fails()) {
     return redirect()->back()
         ->withErrors($validator)
         ->withInput();
 }
  $emergency_active=EmeregencyStatus::create([
          'type'=>$request->type,
            'active'=>1,
  ]);
       return redirect()->back();

  }

}
