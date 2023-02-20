<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MentorUpdateRequest extends FormRequest
{
 
    public function rules()
    {
        return [
            'name' => 'string',
            'profile' => 'url',
            'profession' => 'string',
            'email' => 'email'
        ];
    }
}
