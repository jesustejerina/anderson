<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'=>'required|string|email|max:100',
            'password'=>'required|string|min:8'
        ];
    }

    public function messages() : array
    {
        return [
            'email.required' => 'Ingrese correo electrónico.',
            'email.email'=>'El email no tiene un formato adecuado.',
            'email.max' => 'Máximo 100 caracteres',
            'password.required'=>'Ingrese clave.',
            'password.min'=>'Clave mínimo 8 caracteres.'
        ];
    }

    protected function failedValidation(Validator $validator) : Json
    {
        $errors="";
        
        foreach($validator->errors()->messages() as $error){
            $errors.=$error[0]." ";
        };

        throw new HttpResponseException(response()->json([
            'status'=>'ERROR',
            'message' => $errors
        ])->setStatusCode(401,'La información enviada no es válida.'));
    }
}
