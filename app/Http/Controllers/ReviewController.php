<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Requests\ReviewUpdateRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request)
    {
        $userId = $request->input('user_id');
        $user = getUser($userId);

        if ($user['status'] === 'error') {
            return response()->json([
                'status' => $user['status'],
                'message' => $user['message']
            ], $user['http_code']);
        }

        $isExistsReview = Review::where('course_id', $request->input('course_id'))
            ->where('user_id', $userId)
            ->exists();

        if ($isExistsReview) {
            return response()->json([
                'status' => 'error',
                'message' => 'review already exists'
            ], 409);
        }

        $review = Review::create($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => $review
        ]);
    }

    public function update(ReviewUpdateRequest $request, $id)
    {
        $data = $request->except('user_id', 'course_id');

        $review = Review::find($id);

        if(!$review) {
            return response()->json([
                'status' => 'error',
                'message' => 'review not found'
            ]);

        }

        $review->fill($data)->save();
        return response()->json([
            'status' => 'success',
            'data' => $review
        ]);
    }

    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['status' => 'error', 'message' => 'review not found'], 404);
        }
        $review->delete();
        return response()->json([
            'status' => 'success',
            'data' => 'review deleted'
        ]);
    }
}
