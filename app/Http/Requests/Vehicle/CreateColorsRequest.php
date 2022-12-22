<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class CreateColorsRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:colors,name,NULL,id,deleted_at,NULL',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre del color es requerido',
            'name.unique' => 'El nombre del color ya existe, por favor ingrese otro',
            'name.string' => 'El nombre del color debe ser una cadena de texto',
            'name.max' => 'El nombre del color no debe exceder los 255 caracteres',
        ];
    }
}
