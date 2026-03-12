<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MonEvenementController extends Controller
{
    public function index()
    {
        $utilisateur = Auth::user();

        //les evenements que j'ai crees
        $mesEvenements = $utilisateur->evenements()->latest()->get();

        // Les événements auxquels je suis inscrit
        $mesInscriptions = $utilisateur->inscriptions()->with('evenement')->latest()->get();

        return view('mes-evenements.index', compact('mesEvenements', 'mesInscriptions'));
    }
}