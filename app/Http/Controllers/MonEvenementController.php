<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;    

class MonEvenementController extends Controller
{
    public function index()
    {
        /** @var User $utilisateur */ 
        $utilisateur = Auth::user();

        
        $mesEvenements = $utilisateur->evenements()->latest()->get();

        
        $mesInscriptions = $utilisateur->inscriptions()->with('evenement')->latest()->get();

        return view('mes-evenements.index', compact('mesEvenements', 'mesInscriptions'));
    }
}