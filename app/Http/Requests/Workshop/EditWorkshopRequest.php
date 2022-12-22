<?php

namespace App\Http\Requests\Workshop;

use Illuminate\Foundation\Http\FormRequest;

class EditWorkshopRequest extends FormRequest
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
            'name' =>  [ 'required','string','unique:workshops,name,'.$this->workshop->id.',id,deleted_at,NULL'],
        ];
    }


    public function messages()
    {
        // mensajes en español
        return [
            'name.required' => 'El nombre del taller es requerido.',
            'name.unique' => 'Este taller ya esta registrado.',
        ];
    }
}
