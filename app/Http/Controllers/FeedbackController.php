<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
          return response()->json([  'status' => false,'message' => 'Unauthorized'], 401);
      }

      // Validate that the token matches the latest token
      if ($user->latest_token !== $hashedToken) {
          return response()->json([  'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
      }

      // Check if the token has the required capability
      if (!$user->tokenCan('API TOKEN')) {
          return response()->json([  'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
      }

      // Get the user ID
      $userid = $user->id;
        DB::beginTransaction();
        try {
            $request->validate([
                'usertext' => 'required|string',
            ]);

            $feedback = new Feedback();
            $feedback->users_id =   $userid; // assumes user is authenticated
            $feedback->usertext = $request->usertext;
            $feedback->save();

            // Assuming you want to return all feedback from the current user
            $paginatedFeedback = Feedback::where('users_id',   $userid)->latest()->paginate(10);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'You have submitted feedback successfully',
                'data' => $feedback,
                'pagination' => $paginatedFeedback
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([  'status' => false,'message' => 'Error processing your request: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
