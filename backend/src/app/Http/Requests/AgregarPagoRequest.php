<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AgregarPagoRequest extends FormRequest
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
            'forma' => 'required|string',
            'detalle' => 'required|string|max:200',
            'monto' => 'required|numeric',
            'cliente_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'forma.required' => 'El campo forma es requerido.',
            'forma.string' => 'El campo forma debe ser una cadena de texto.',
            'detalle.required' => 'El campo detalle es requerido.',
            'detalle.string' => 'El campo detalle debe ser una cadena de texto.',
            'detalle.max' => 'El campo detalle no puede tener más de 200 caracteres.',
            'monto.required' => 'El campo monto es requerido.',
            'monto.numeric' => 'El campo monto debe ser un número.',
            'cliente_id.required' => 'El campo cliente es requerido.',
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
