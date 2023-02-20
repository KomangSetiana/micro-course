<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonUpdateRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'name' => "string",
            'video' => "string",
            'chapter_id' => 'integer|exists:chapters,id',
        ];
    }
}
