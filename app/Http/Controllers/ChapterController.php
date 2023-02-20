<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterRequest;
use App\Http\Requests\ChapterUpdateRequest;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{

    public function index(Request $request)
    {
        $course = Chapter::query();

       
        $courseId = $request->query('course_id');

        $course->when($courseId, function ($query) use ($courseId) {
            return $query->where('course_id', $courseId);
        });

        return response()->json(['status' => 'success', 'data' => $course->get()]);
    }
    public function store(ChapterRequest $request)
    {
        $chapter = Chapter::create($request->validated());
        return response()->json(['status' => 'success', 'data' => $chapter]);
    }
    public function update(ChapterUpdateRequest $request, $id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json(['status' => 'error', 'message' => 'chapter not found'], 404);
        }

        $chapter->fill($request->validated())->save();

        return response()->json([
            'status' => 'success',
            'data' => $chapter
        ]);
    } 
    public function show($id)
    {
        $chapter = Chapter::find($id);
     
        if(!$chapter){
            return response()->json(['status' => 'error', 'message' => 'chapter not found'],404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $chapter
        ]);
    }

    public function destroy($id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json(['status' => 'error', 'message' => 'chapter not found'], 404);
        }
        $chapter->delete();
        return response()->json([
            'status' => 'success',
            'data' => 'chapter deleted'
        ]);
    }
}
