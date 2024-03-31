<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:users,email',
            'first_name' => 'required|min:1|max:50',
            'last_name' => 'required|min:1|max:50',
            'password' => 'required|min:8|max:15',
            'confirm_password' => 'required|same:password'
        ];
    }
}
