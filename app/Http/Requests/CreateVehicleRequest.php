<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVehicleRequest extends FormRequest
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
            'chassis_number' => 'required|string',
            'brand_id' => 'required',
            'model_id' => 'required',
            'color_id' => 'required',
            'company' => 'required|string',
            // 'year' => 'nullable|string',
            // 'mileage' => 'nullable|string',
            // 'price' => 'nullable|integer',
            // 'description' => 'nullable|string',
            // 'observation' => 'nullable|string',
            // 'status' => 'nullable|integer',
            'gallery' => 'required|array|min:1',
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
            'chassis_number.required' => 'El número de número chasis es requerido',
            'chassis_number.string' => 'El número de chasis debe ser una cadena de texto',
            'brand_id.required' => 'La marca es requerida',
            //'brand_id.integer' => 'La marca debe ser un número entero',
            'model_id.required' => 'El modelo es requerido',
            //'model_id.integer' => 'El modelo debe ser un número entero',
            'color_id.required' => 'El color es requerido',
            //'color_id.integer' => 'El color debe ser un número entero',
            // 'year.string' => 'El año debe ser una cadena de texto',
            // 'mileage.string' => 'El kilometraje debe ser una cadena de texto',
            // 'price.integer' => 'El precio debe ser un número entero',
            // 'description.string' => 'La descripción debe ser una cadena de texto',
            // 'observation.string' => 'La observación debe ser una cadena de texto',
            // 'status.integer' => 'El estado debe ser un número entero',
            'gallery.required' => 'La imagenes son requeridas',
            'gallery.array' => 'La imagenes deben ser un arreglo',
            'gallery.min' => 'La galería debe tener al menos una imagen',
        ];
    }
}
