<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
        if($this->nuevo=="SI"){
            return [
                'name'=>'required|string|max:50',
                'email'=>'required|string|email|unique:users,email|max:100',
                'password'=>'required|string|confirmed|min:8',
                'role'=>'required',
                'avatar'=>'file|mimes:png,jpg,jpeg'
            ];
        }
        if($this->nuevo=="NO"){
            return [
                'name'=>'required|string|max:50',
                'role'=>'required'
            ];
        }
         
    }

    public function messages() : array
    {
        return [
            'name.required' => 'Ingrese nombre de usuario.',
            'name.max' => 'Máximo 50 caracteres',
            'email.required' => 'Ingrese correo electrónico.',
            'email.email'=>'El email no tiene un formato adecuado.',
            'email.unique'=>'Email ya registrado',
            'email.max' => 'Máximo 100 caracteres',
            'password.required'=>'Ingrese clave.',
            'password.confirmed'=>'La clave no es la misma.',
            'password.min'=>'Clave mínimo 8 caracteres.',
            'role.required'=>'Debe elegir un rol',
            'avatar.file'=>'No agregó foto',
            'avatar.mimes'=>'La foto solo puede ser png o jpg',
            'avatar.max'=>'Tamaño de foto muy grande. Máximo 300Kb'
        ];
    }

    protected function failedValidation(Validator $validator) : Json
    {
        $errors="";
        
        foreach($validator->errors()->messages() as $error){
            $errors.=$error[0]." ";
        };

        throw new HttpResponseException(response()->json([
            'status'=>'ERROR_VALIDACION',
            'errors' => $validator->errors()
        ])->setStatusCode(422,'No se pudo Registrar'));
    }
}
