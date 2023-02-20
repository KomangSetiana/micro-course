<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChapterRequest extends FormRequest
{
  
    public function rules()
    {
        return [
            'name' => "required|string",
            'course_id' => 'integer|required|exists:courses,id',
        ];
    }
}
