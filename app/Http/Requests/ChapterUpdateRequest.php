<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChapterUpdateRequest extends FormRequest
{
   
    public function rules()
    {
        return [
            'name' => "string",
            'course_id' => 'integer|exists:courses,id',
        ];
    }
}
