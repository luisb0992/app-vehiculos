<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class EditRolRequest extends FormRequest
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
            'name' =>  [ 'required','string','unique:roles,name,'.$this->role->id.',id,deleted_at,NULL'],
        ];
    }


    public function messages()
    {
        // mensajes en español
        return [
            'name.required' => 'El nombre del rol es requerido.',
            'name.unique' => 'Este rol ya esta registrado.',
        ];
    }
}
