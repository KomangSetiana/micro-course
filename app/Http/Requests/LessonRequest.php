<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'name' => "required|string",
            'video' => "required|string",
            'chapter_id' => 'integer|required|exists:chapters,id',
        ];
    }
}
