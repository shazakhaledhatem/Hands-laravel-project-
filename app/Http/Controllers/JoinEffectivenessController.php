<?php

namespace App\Http\Controllers;

use App\Models\JoinEffectiveness;
use App\Models\Effectiveness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class JoinEffectivenessController extends Controller
{

  // Function to join with effectiveness
     public function joinWithEffectiveness(Request $request,$effectivenessId)
     {

         $user = Auth::guard('api')->user(); // Authentication for API guard
         if (!$user) {
             return response()->json(['message' => 'Unauthorized'], 401);
         }

         $volunteerId = $user->id;


         $effectiveness = Effectiveness::find($effectivenessId);

         if ($effectiveness->numberofparicipations > $effectiveness->numberofvolunteer) {
             return response()->json(['message' => 'Effectiveness is full. Volunteer cannot join.'], 400);
         }

         // Check if the volunteer has already joined this effectiveness
            $existingRecord = JoinEffectiveness::where('volenteer_id', $volunteerId)
                ->where('effectiveness_id', $effectivenessId)
                ->first();

            if ($existingRecord) {
                return response()->json(['message' => 'Volunteer has already joined this effectiveness.'], 400);
            }


         $record = JoinEffectiveness::create([
             'charities_id' => $effectiveness->charities_id,
             'volenteer_id' => $volunteerId,
             'effectiveness_id' => $effectivenessId,
             'status' => 'pending',
         ]);

         $effectiveness->numberofparicipations++;

          $effectiveness->save();

         return response()->json([
             'status' => true,
             'message' => 'Volunteer joined effectiveness successfully',
             'data' => [

                 'record' => $record
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
 //////////////Function to unjoin with effectiveness
 public function UnjoinWithEffectiveness(Request $request,$effectivenessId)
 {

     $user = Auth::guard('api')->user(); // Authentication for API guard
     if (!$user) {
         return response()->json(['message' => 'Unauthorized'], 401);
     }

     $volunteerId = $user->id;


     $effectiveness = Effectiveness::find($effectivenessId);



     // Check if the volunteer has already joined this effectiveness
        $existingRecord = JoinEffectiveness::where('volenteer_id', $volunteerId)
            ->where('effectiveness_id', $effectivenessId)
            ->first();

        if (!$existingRecord) {
            return response()->json(['message' => 'you are not included.'], 400);
        }


        $record = JoinEffectiveness::where('volenteer_id', $volunteerId)
                           ->where('effectiveness_id',$effectivenessId)
                            ->first();
                            $record->delete();

     $effectiveness->numberofparicipations--;

      $effectiveness->save();

     return response()->json([
         'status' => true,
         'message' => 'Volunteer joined effectiveness successfully',
         'data' => [

             'record' => $record
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

  
 }
