<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewUpdateRequest extends FormRequest
{
 
    public function rules()
    {
        return [
            'rating' => 'integer|min:1|max:5',
            'note' => 'string'
        ];
    }
}
