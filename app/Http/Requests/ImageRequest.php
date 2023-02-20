<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
   
    public function rules()
    {
        return [
            'image' => "required|url",
            'course_id' => 'integer|required|exists:courses,id',
        ];
    }
}
