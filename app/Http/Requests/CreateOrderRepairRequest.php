<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRepairRequest extends FormRequest
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
            'vehicle_id' => 'required|integer',
            'orders' => 'required|array|min:1',
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
            'vehicle_id.required' => 'El vehículo es requerido',
            'vehicle_id.integer' => 'El vehículo debe ser un número entero',
            'orders.required' => 'Debe seleccionar al menos una orden de reparación',
            'orders.array' => 'Las órdenes de reparación deben ser un arreglo',
            'orders.min' => 'Debe seleccionar al menos una orden de reparación',
        ];
    }
}
