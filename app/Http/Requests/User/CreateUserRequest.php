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
            'email' => 'email|unique:users,email',
            'last_name' => 'required|min:3|max:80',
            'dni' => 'required|min:5|max:20|unique:users,dni',
            'rol_id' => 'required',
            'workshop_id' => 'required|exclude_if:rol_id,4',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages()
    {
        // mensajes en español
        return [
            'workshop_id.required' => 'El taller es requerido.',
            'rol_id.required' => 'El  rol es requerido.',
        ];
    }
}
