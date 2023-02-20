<?php

namespace App\Http\Controllers;

use App\Http\Requests\MentorRequest;
use App\Http\Requests\MentorUpdateRequest;
use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends Controller
{

    public function index()
    {
        $mentor = Mentor::all();
        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }
    public function show($id)
    {
        $mentor = Mentor::find($id);
     
        if(!$mentor){
            return response()->json(['status' => 'error', 'message' => 'mentor not found'],404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }
    public function store(MentorRequest $request)
    {
       
        $validatedata = Mentor::create($request->validated());

        return response()->json(['status' => 'success', 'data' => $validatedata]);
    }

    public function update(MentorUpdateRequest $request, $id)
    {
        $mentor = Mentor::find($id);
     
        if(!$mentor){
            return response()->json(['status' => 'error', 'message' => 'mentor not found'],404);
        }

        $mentor->fill($request->validated())->save();
      
        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }

    public function destroy($id)
    {
        $mentor = Mentor::find($id);

        if(!$mentor){
            return response()->json(['status' => 'error', 'message' => 'mentor not found'],404);
        }
        $mentor->delete();
        return response()->json([
            'status' => 'success',
            'data' => 'mentor deleted'
        ]);
    }
}
