<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class EditBrandsRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:brands,name,'.$this->brand->id.',id,deleted_at,NULL',
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
            'name.required' => 'El nombre de la marca es requerido',
            'name.unique' => 'El nombre de la marca ya existe, por favor ingrese otro',
            'name.string' => 'El nombre de la marca debe ser una cadena de texto',
            'name.max' => 'El nombre de la marca no debe exceder los 255 caracteres',
        ];
    }
}
