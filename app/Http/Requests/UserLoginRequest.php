<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'email'=>'required|email',
            'password'=>'required',
        ];
    }

    public function messages() {
        return [
            'email.required'=>'L\'email est requis',
            'email.email'=>'L\'email doit être de type email',
            'password.required'=>'Le mot de passe est requis',
        ];
    }
}
