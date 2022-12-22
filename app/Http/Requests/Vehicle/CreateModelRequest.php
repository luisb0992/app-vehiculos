<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class CreateModelRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:model_vehicles,name,NULL,id,deleted_at,NULL',
            'brand_id' => 'required|integer|exists:brands,id',
        ];
    }

    public function messages()
    {
        // mensajes en español
        return [
            'name.required' => 'El nombre es requerido.',
            'name.min' => 'El nombre debe tener un minimo de 3 caracteres.',
            'brand_id.required' => 'La marca es un campo requerido.',
        ];
    }
}
