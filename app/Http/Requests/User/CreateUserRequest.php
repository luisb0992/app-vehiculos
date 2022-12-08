<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:60',
            'email' => 'email',
            'last_name' => 'required|min:3|max:80',
            'dni' => 'required|min:8|max:8',
            'rol_id' => 'required',
            'workshop_id' => 'required',
            'password' => 'required|confirmed|min:6',
        ];
    }
}
