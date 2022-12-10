<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'last_name' => 'required|min:3|max:80',
            'dni' =>  [ 'required','unique:users,email,'.$this->user->id],
            'email' => [ 'required','email','unique:users,email,'.$this->user->id],
            'rol_id' => 'required',
            'workshop_id' => 'required',
        ];
    }
}
