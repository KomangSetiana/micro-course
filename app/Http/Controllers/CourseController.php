<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\MyCourse;
use App\Models\Review;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        $cource = Course::query();

        $q = $request->query('q');
        $status = $request->query('status');

        $cource->when($q, function ($query) use ($q) {
            return $query->whereRaw("name LIKE '%" . strtolower($q) . "%'");
        });
        $cource->when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        });

        return response()->json(['status' => 'success', 'data' => $cource->paginate(10)]);
    }
    public function store(CourseRequest $request)
    {
        $course = Course::create($request->validated());
        return response()->json(['status' => 'success', 'data' => $course]);
    }

    public function show($id)
    {
        $course = Course::with(['chapters.lessons', 'mentor', 'images'])->find($id);
        if (!$course) {
            return response()->json([
                'status' => 'success',
                'message' => 'course not found'
            ]);
        }

        $reviews = Review::where('course_id', $id)->get()->toArray();
        if (count($reviews) > 0) {
            $userIds = array_column($reviews, 'user_id');
            $users = getUserByIds($userIds);
            // dd($users);
            // echo "<pre>".print_r($users, 1)."</pre>";
            if ($users['status'] === 'error') {
                $reviews = [];
            } else {
                foreach ($reviews as $key => $review) {
                    $userIndex = array_search($review['user_id'], array_column($users['data'], 'id'));
                    $reviews[$key]['users'] = $users['data'][$userIndex];
                }
            }
        }
        $totalStudent = MyCourse::where('course_id', $id)->count();
        $totalVideos = Chapter::where('course_id', $id)->withCount('lessons')->get()->toArray();
        $finalTotalVideos = array_sum(array_column($totalVideos, 'lessons_count'));

        $course['reviews'] = $reviews;
        $course['total_videos'] = $finalTotalVideos;
        $course['total_student'] = $totalStudent;

        return response()->json([
            'status' => 'success',
            'data' => $course
        ]);
    }
    public function update(CourseUpdateRequest $request, $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['status' => 'error', 'message' => 'course not found'], 404);
        }

        $course->fill($request->validated())->save();

        return response()->json([
            'status' => 'success',
            'data' => $course
        ]);
    }
    public function destroy($id)
    {
        $cource = Course::find($id);

        if (!$cource) {
            return response()->json(['status' => 'error', 'message' => 'course not found'], 404);
        }
        $cource->delete();
        return response()->json([
            'status' => 'success',
            'data' => 'cource deleted'
        ]);
    }
}
