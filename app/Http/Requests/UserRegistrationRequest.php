<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
            'firstname'=>'required|min:3',
            'lastname'=>'required|min:3',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'gender' => 'required|in:Male,Female',
            'birthDate' => 'required|date',
            'location' => 'required|exists:locations,id',
        ];
    }

    public function messages() {
        return [
            'firstname.required'=>'Le prénom est requis',
            'firstname.min'=>'Le prénom doit avoir minimum 3 caractères',
            'lastname.required'=>'Le nom est requis',
            'lastname.min'=>'Le nom doit avoir minimum 3 caractères',
            'email.required'=>'L\'email est requis',
            'email.email'=>'L\'email doit être de type email',
            'email.unique'=>'Cet email est déjà utilisé',
            'password.required'=>'Le mot de passe est requis',
            'password.min'=>'Le mot de passe doit avoir au moins 6 caractères',
            'gender.required'=>'Le genre est requis',
            'gender.in'=>'Veuillez choisir le genre',
            'birthDate.required'=>'La date est requise',
            'location.required'=>'La ville est requise',
        ];
    }
}
