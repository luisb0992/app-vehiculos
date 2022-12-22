<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBrandRequest extends FormRequest
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
            'name' => 'required|string|unique:brands,name,NULL,id,deleted_at,NULL',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        // mensajes en español
        return [
            'name.required' => 'El nombre de la marca es requerido',
            'name.string' => 'El nombre de la marca debe ser una cadena de texto',
            'name.unique' => 'El nombre de la marca ya existe, por favor ingrese otro nombre',
        ];
    }
}
