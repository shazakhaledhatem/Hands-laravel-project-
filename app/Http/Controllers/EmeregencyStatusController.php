<?php

namespace App\Http\Controllers;

use App\Models\EmeregencyStatus;
use Illuminate\Http\Request;

class EmeregencyStatusController extends Controller
{

  public function getemergencyactive(Request $request)
  {
      // Check if there is any record with active set to true
      $hasActiveStatus = EmeregencyStatus::where('active', true)->exists();

      if (!$hasActiveStatus) {
          return response()->json(['status' => false, 'message' => 'Emergency status is false.'], 200);
      }

      // Retrieve the active emergency statuses
      $emergencyStatuses = EmeregencyStatus::where('active', true)->get();

      return response()->json([
          'status' => true,
          'message' => 'Emergency status is true.',
          'data' => $emergencyStatuses,
          'pagination' => [],
      ], 200);
  }





}
