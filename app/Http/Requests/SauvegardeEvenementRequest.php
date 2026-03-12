<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SauvegardeEvenementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'=>'required|string|max:255',
            'description'=>'required|string',
            'lieu'=>'required|string|max:255',
            'categorie'=>'required|string',
            'date'=>'required|date',
            'heure'=>'required',
            'nombre_max_participants'=>'required|integer|min:1',
            'image'=>'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'=> 'Le nom est obligatoire.',
            'description.required'=> 'La description est obligatoire.',
            'lieu.required'=> 'Le lieu est obligatoire.',
            'categorie.required'=> 'La catégorie est obligatoire.',
            'date.required'=> 'La date est obligatoire.',
            'heure.required'=> 'L\'heure est obligatoire.',
            'nombre_max_participants.required' => 'Le nombre de participants est obligatoire.',
            'nombre_max_participants.min'=> 'Au moins 1 participant.',
            'image.image'=> 'Ce doit être une image.',
            'image.max'=> 'L\'image ne doit pas dépasser 2MB.',
        ];
    }
}