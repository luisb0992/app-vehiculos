<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkshopQuoteRequest extends FormRequest
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
            'repair_order_id' => 'required|integer',
            'workshop_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'subtotal' => 'required|numeric',
            'tax' => 'required|numeric',
            'total' => 'required|numeric',
            'subs' => 'required|array|min:1',
            // 'invoice_number' => 'required|string',
            // 'invoice' => 'required|file',
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
            'repair_order_id.required' => 'El id de la orden de reparación es requerido',
            'repair_order_id.integer' => 'El id de la orden de reparación debe ser un número entero',
            'workshop_id.integer' => 'El id del taller debe ser un número entero',
            'user_id.integer' => 'El id del usuario debe ser un número entero',
            'subtotal.required' => 'El subtotal es requerido',
            'subtotal.numeric' => 'El subtotal debe ser un número',
            'tax.required' => 'El iva es requerido',
            'tax.numeric' => 'El iva debe ser un número',
            'total.required' => 'El total es requerido',
            'total.numeric' => 'El total debe ser un número',
            'subs.required' => 'Los servicios son requeridos',
            'subs.array' => 'Los servicios deben ser un arreglo',
            'subs.min' => 'Los servicios deben tener al menos un servicio',
            // 'invoice_number.required' => 'El número de factura es requerido',
            // 'invoice_number.string' => 'El número de factura debe ser una cadena de texto',
            // 'invoice.required' => 'La factura es requerida',
            // 'invoice.file' => 'La factura debe ser un archivo',
        ];
    }
}
