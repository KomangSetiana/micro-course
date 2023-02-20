<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\ImageCourse;
use Illuminate\Http\Request;

class ImageController extends Controller
{
  public function store(ImageRequest $request)
  {
    $imageCourse = ImageCourse::create($request->validated());
        return response()->json(['status' => 'success', 'data' => $imageCourse]);
  }
  public function destroy($id)
  {
      $imageCourse = ImageCourse::find($id);

      if (!$imageCourse) {
          return response()->json(['status' => 'error', 'message' => 'image course not found'], 404);
      }
      $imageCourse->delete();
      return response()->json([
          'status' => 'success',
          'data' => 'image course deleted'
      ]);
  }
}
