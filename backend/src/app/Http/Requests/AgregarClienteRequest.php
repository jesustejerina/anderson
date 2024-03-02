<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AgregarClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'email' => 'required|email|max:50',
        ];
    }

    public function messages()
    {
        return [
            'nombres.required' => 'El campo :attribute es requerido.',
            'nombres.string' => 'El campo :attribute debe ser una cadena de texto.',
            'nombres.max' => 'El campo :attribute no puede tener más de 50 caracteres.',
            'apellidos.required' => 'El campo :attribute es requerido.',
            'apellidos.string' => 'El campo :attribute debe ser una cadena de texto.',
            'apellidos.max' => 'El campo :attribute no puede tener más de 50 caracteres.',
            'email.required' => 'El campo :attribute es requerido.',
            'email.email' => 'El campo :attribute debe ser un email válido.',
            'email.max' => 'El campo :attribute no puede tener más de 50 caracteres.',
        ];
    }

    protected function failedValidation(Validator $validator): Json
    {
        $errors = "";

        foreach ($validator->errors()->messages() as $error) {
            $errors .= $error[0] . " ";
        };

        throw new HttpResponseException(response()->json([
            'status' => 'ERROR_VALIDACION',
            'errors' => $validator->errors(),
        ])->setStatusCode(422, 'Faltan datos'));
    }
}
