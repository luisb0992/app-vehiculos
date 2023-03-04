<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
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
            "quotation_id" => "required|integer",
            'invoice_number' => 'required|string',
            'invoice' => 'required|file|max:5000',
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
            'quotation_id.required' => 'La cotización relacionada es requerida',
            'invoice_number.required' => 'El número de factura es requerido',
            'invoice_number.string' => 'El número de factura debe ser una cadena de texto',
            'invoice.required' => 'La factura es requerida',
            'invoice.file' => 'La factura debe ser un archivo',
            'invoice.max' => 'La factura debe pesar menos de 5MB',
        ];
    }
}
