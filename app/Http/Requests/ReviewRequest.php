<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'course_id' => 'required|integer|exists:courses,id',
            'rating' => 'required|integer|min:1|max:5',
            'note' => 'string'
        ];
    }
}
