<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Http\Requests\LessonUpdateRequest;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    public function index(Request $request)
    {
        $course = Lesson::query();

       
        $chapterId = $request->query('chapter_id');

        $course->when($chapterId, function ($query) use ($chapterId) {
            return $query->where('chapter_id', $chapterId);
        });

        return response()->json(['status' => 'success', 'data' => $course->get()]);
    }

    public function show($id)
    {
        $lesson = Lesson::find($id);
     
        if(!$lesson){
            return response()->json(['status' => 'error', 'message' => 'lesson not found'],404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ]);
    }
    public function store(LessonRequest $request)
    {
        $lesson = Lesson::create($request->validated());
        return response()->json(['status' => 'success', 'data' => $lesson]);
    }

    public function update(LessonUpdateRequest $request, $id)
    {
        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json(['status' => 'error', 'message' => 'lesson not found'], 404);
        }

        $lesson->fill($request->validated())->save();

        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ]);
    }
    
    public function destroy($id)
    {
        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json(['status' => 'error', 'message' => 'lesson not found'], 404);
        }
        $lesson->delete();
        return response()->json([
            'status' => 'success',
            'data' => 'lesson deleted'
        ]);
    }
}
