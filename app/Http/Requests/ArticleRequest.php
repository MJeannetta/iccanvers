<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'titre' => 'required|min:3',
            'description' => 'required|min:10',
        ];
    }

    public function messages() {
        return [
            'titre.required' => 'Veuillez entrer le titre',
            'titre.min' => 'Le titre doit contenir au moins 3 lettres !',
            'description.required' => 'Veuillez décrire le titre',
            'description.min' => 'La description doit contenir minimum 10 lèttres!',
        ];
    }
}
