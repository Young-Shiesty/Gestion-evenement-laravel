<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Http\Requests\SauvegardeEvenementRequest;
use App\Http\Requests\MettreAJourEvenementRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EvenementController extends Controller
{
    public function index(Request $request)
    {
        $query = Evenement::query();

        if ($request->filled('recherche')) {
            $query->where('nom', 'like', '%' . $request->recherche . '%');
        }

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        if ($request->filled('lieu')) {
            $query->where('lieu', 'like', '%' . $request->lieu . '%');
        }
        if ($request->filled('date')) {
                $query->where('date', $request->date);
        }
    
        $evenements = $query->latest()->get();

        return view('evenements.index', compact('evenements'));
    }
    public function creer()
    {
        return view('evenements.creer');
    }
    public function sauvegarder(SauvegardeEvenementRequest $request)
    {
        $donnees = $request->validated();

        // On ajoute l'id du createur
        $donnees['user_id'] = Auth::id();

        // Si une image est envoye on la sauvegarde
        if ($request->hasFile('image')) {
            $donnees['image'] = $request->file('image')->store('evenements', 'public');
        }

        Evenement::create($donnees);

        return redirect()->route('evenements.index')->with('succes', 'Événement créé avec succès !');
    }

    public function afficher(Evenement $evenement)
    {
        $participants = $evenement->participants;

        // Verifier si l'utilisateur connecte est deja inscrit
        if (Auth::check()) {
            $dejaInscrit = $participants->contains(Auth::id());
        } else {
            $dejaInscrit = false;
        }

        return view('evenements.afficher', compact('evenement', 'participants', 'dejaInscrit'));
    }
    public function editer(Evenement $evenement)
    {
        // Seul le createur peut modifier
        if ($evenement->user_id !== Auth::id()) {
            return redirect()->route('evenements.index')->with('erreur', 'Seul le creator peut modif.');
        }

        return view('evenements.editer', compact('evenement'));
    }
    public function mettreAJour(MettreAJourEvenementRequest $request, Evenement $evenement)
    {
        // Seul le createur peut modifier
        if ($evenement->user_id !== Auth::id()) {
            return redirect()->route('evenements.index')->with('erreur', 'Seul le creator peut modif.');
        }

        $donnees = $request->validated();

        // Si une nouvelle image est envoyée
        if ($request->hasFile('image')) {
            // On supprime l'ancienne image si elle existe
            if ($evenement->image) {
                Storage::disk('public')->delete($evenement->image);
            }
            // On sauvegarde la nouvelle
            $donnees['image'] = $request->file('image')->store('evenements', 'public');
        }
        $evenement->update($donnees);
        return redirect()->route('evenements.index')->with('succes', 'Événement modifié avec succès !');
    }
    public function supprimer(Evenement $evenement)
    {
        // Seul le createur peut supprimer
        if ($evenement->user_id !== Auth::id()) {
            return redirect()->route('evenements.index')->with('erreur', 'Seule le creator peut modif.');
        }

        // Supprimer l'image si elle existe
        if ($evenement->image) {
            Storage::disk('public')->delete($evenement->image);
        }
        $evenement->delete();
        return redirect()->route('evenements.index')->with('succes', 'Evenement supprime avec succès !');
    }
    public function participants(Evenement $evenement)
    {
    if ($evenement->user_id !== Auth::id()) {
        return redirect()->route('evenements.index')
        ->with('erreur', 'Action non autorisée.');
    }
    $participants = $evenement->participants;
    return view('evenements.participants', compact('evenement', 'participants'));
}
}