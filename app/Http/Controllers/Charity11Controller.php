<?php

namespace App\Http\Controllers;


use App\Models\LocationThatCoveredByCharities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

  use Illuminate\Support\Facades\Http;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Storage;
use App\Models\Charity11; // Ensure you have the correct model namespace
use Laravel\Sanctum\HasApiTokens;

class Charity11Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


   public function register(Request $request)
   {
       try {
           // Validate the request data
           $validator = Validator::make($request->all(), [
               'name' => 'required',
               'email' => 'required|email|unique:charities,email',
               'password' => 'required',
               'image' => 'required|image',
               'address' => 'required',
               'nameoftheheadofcharity' => 'required',
               'vicepresidentofcharity' => 'required',
               'typeofcharity' => 'required',
               'nameofcashier' => 'required',
               'numberbankaccount' => 'required',
               'licensenumber' => 'required',
               'numberofvolunteer' => 'required',
               'charityphone' => 'required',
               'whatsappnumber' => 'required',
               'linkoffacebookpage' => 'required',
               'linkwebsite' => 'required',
           ]);

           if ($validator->fails()) {
               return response()->json([
                   'status' => false,
                   'message' => 'Validation error',
                   'errors' => $validator->errors()
               ], 401);
           }

           // Handle the image upload
           if ($request->hasFile('image')) {
               $imagePath = $request->file('image')->store('public/charity_images');
               $imagePath = Storage::url($imagePath);
           }

           // Create the charity data array
           $charityData = [
               'name' => $request->name,
               'email' => $request->email,
               'password' => Hash::make($request->password),
               'address' => $request->address,
               'nameoftheheadofcharity' => $request->nameoftheheadofcharity,
               'vicepresidentofcharity' => $request->vicepresidentofcharity,
               'typeofcharity' => $request->typeofcharity,
               'nameofcashier' => $request->nameofcashier,
               'numberbankaccount' => $request->numberbankaccount,
               'licensenumber' => $request->licensenumber,
               'numberofvolunteer' => $request->numberofvolunteer,
               'linkwebsite' => $request->linkwebsite,
               'charityphone' => $request->charityphone,
               'whatsappnumber' => $request->whatsappnumber,
               'linkoffacebookpage' => $request->linkoffacebookpage,
               'image' => $imagePath ?? null,
               'created_at' => now(),
               'updated_at' => now(),
           ];

           // Insert the charity data and get the inserted record's ID
           $charityId = DB::table('charity11s')->insertGetId($charityData);

           // Retrieve the newly inserted record as a model instance
           $charity = Charity11::find($charityId);

           // Create an API token for the charity
           $token = $charity->createToken("API TOKEN")->plainTextToken;

           // Prepare the response data
           $charityDataResponse = [
               'token' => $token,
               'charity' => $charity
           ];

           // Paginate the charities
           $charities = Charity11::paginate(10); // Adjust the pagination as needed


           return response()->json([
               'status' => true,
               'message' => 'Charity Created Successfully',
               'data' => $charityDataResponse,
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
       } catch (\Throwable $th) {
           return response()->json([
               'status' => false,
               'message' => $th->getMessage()
           ], 500);
       }
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Charity11  $charity11
     * @return \Illuminate\Http\Response
     */
    public function show(Charity11 $charity11)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Charity11  $charity11
     * @return \Illuminate\Http\Response
     */
    public function edit(Charity11 $charity11)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Charity11  $charity11
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Charity11 $charity11)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Charity11  $charity11
     * @return \Illuminate\Http\Response
     */
    public function destroy(Charity11 $charity11)
    {
        //
    }
}
