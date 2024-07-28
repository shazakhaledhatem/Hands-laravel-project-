<?php

namespace App\Http\Controllers;

use App\Models\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class SliderController extends Controller
{
  public function storeImages(Request $request)
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
          return response()->json([  'status' => false,'message' => 'Unauthorized'], 401);
      }

      // Validate that the token matches the latest token
      if ($charity->latest_token !== $hashedToken) {
          return response()->json([  'status' => false,'message' => 'Unauthorized: Invalid token'], 401);
      }

      // Check if the token has the required capability
      if (!$charity->tokenCan('Charity Access Token')) {
          return response()->json([  'status' => false,'message' => 'Unauthorized: Token does not have the required capability.'], 403);
      }
  $imagePaths;
      // Get the user ID
      $charityid = $charity->id;
      /*  $request->validate([
            'image' => 'required',

        ]);*/

        if ($request->hasFile('image')) {
           $imagePath = $request->file('image')->store('public/slider'); // Store image
           $imagePath = Storage::url($imagePath); // Get URL to saved image
          //  $slider->image=$imagePath;
            //  $slider->save();
        }
      else{
          $slider->image=null;
      }


      $slider=slider::create([
        'charities_id'=>  $charityid,
    'image'=>  $imagePath
      ]);
        return response()->json([
            'status' => true,
            'message' => 'Images uploaded successfully',
            'data' => [$slider]
        ], 200);
    }



    public function indexImages(Request $request)
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
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        // Validate that the token matches the latest token
        if ($charity->latest_token !== $hashedToken) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: Invalid token',
            ], 401);
        }

        // Check if the token has the required capability
        if (!$charity->tokenCan('Charity Access Token')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: Token does not have the required capability.',
            ], 403);
        }

        // Get the user ID
        $charityid = $charity->id;

        // Get the slider images for the charity with pagination
        $sliders = Slider::where('charities_id', $charityid)->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Images retrieved successfully',
            'data' => $sliders->items(),
            'pagination' => [
                'current_page' => $sliders->currentPage(),
                'total_pages' => $sliders->lastPage(),
                'total_items' => $sliders->total(),
                'items_per_page' => $sliders->perPage(),
            ],
        ], 200);
    }

      public function deleteImage($id)
{
    // Retrieve the authenticated user
    $charity = Auth::guard('api-charities')->user();

    // Check if user is authenticated
    if (!$charity) {
        return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
    }

    // Find the slider image by ID and charity ID
    $slider = slider::where('id', $id)->where('charities_id', $charity->id)->first();

    if (!$slider) {
        return response()->json(['status' => false, 'message' => 'Image not found'], 404);
    }

    // Delete the image file from storage
    Storage::delete(str_replace('/storage', 'public', $slider->image_path));

    // Delete the slider record from the database
    $slider->delete();

    return response()->json(['status' => true, 'message' => 'Image deleted successfully'], 200);
}

}
