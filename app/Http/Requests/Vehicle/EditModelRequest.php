<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class EditModelRequest extends FormRequest
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
            'name' => 'required|min:3|max:60|unique:model_vehicles,name,'.$this->model->id.',id,brand_id,'.$this->input('brand_id').',deleted_at,NULL',
            'brand_id' => 'required',
        ];
    }

    public function messages()
    {
        // mensajes en español
        return [
            'name.required' => 'El nombre es requerido.',
            'name.unique' => 'Ya existe un modelo con esta marca.',
            'name.min' => 'El nombre debe tener un minimo de 3 caracteres.',
            'brand_id.required' => 'La marca es un campo requerido.',
        ];
    }
}
