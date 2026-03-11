<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EvenementController extends Controller
{
    // Afficher la liste des evenements
    public function index(Request $request)
    {
        $query = Evenement::query();
        // Recherche par nom
        if ($request->filled('recherche')) {
            $query->where('nom', 'like', '%' . $request->recherche . '%');
        }

        // Filtre par categorie
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        // Filtre par date
        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        $evenements = $query->latest()->get();

        return view('evenements.index', compact('evenements'));
    }

    // Afficher le formulaire de creation
    public function creer()
    {
        return view('evenements.creer');
    }

    // Sauvegarder un nouvel evenement
    public function sauvegarder(Request $request)
    {
        // Verification des donnees
        $request->validate([
            'nom'                     => 'required|string|max:255',
            'description'             => 'required|string',
            'lieu'                    => 'required|string|max:255',
            'categorie'               => 'required|string',
            'date'                    => 'required|date',
            'heure'                   => 'required',
            'nombre_max_participants' => 'required|integer|min:1',
            'image'                   => 'nullable|image|max:2048',
        ]);

        // Gestion de l'image
        $cheminImage = null;
        if ($request->hasFile('image')) {
            $cheminImage = $request->file('image')->store('evenements', 'public');
        }

        // Création de l'événement
        Evenement::create([
            'user_id'                 => Auth::id(),
            'nom'                     => $request->nom,
            'description'             => $request->description,
            'lieu'                    => $request->lieu,
            'categorie'               => $request->categorie,
            'date'                    => $request->date,
            'heure'                   => $request->heure,
            'nombre_max_participants' => $request->nombre_max_participants,
            'image'                   => $cheminImage,
        ]);

        return redirect()->route('evenements.index')
                         ->with('succes', 'Événement créé avec succès !');
    }

    // Afficher un seul événement en détail
    public function afficher(Evenement $evenement)
    {
        $participants = $evenement->participants;
        $dejaInscrit  = Auth::check()
            ? $evenement->participants->contains(Auth::id())
            : false;

        return view('evenements.afficher', compact('evenement', 'participants', 'dejaInscrit'));
    }

    // Afficher le formulaire de modification
    public function editer(Evenement $evenement)
    {
        // Seul le créateur peut modifier
        if ($evenement->user_id !== Auth::id()) {
            return redirect()->route('evenements.index')
                             ->with('erreur', 'Vous ne pouvez pas modifier cet événement.');
        }

        return view('evenements.editer', compact('evenement'));
    }

    // Mettre à jour un événement
    public function mettreAJour(Request $request, Evenement $evenement)
    {
        // Seul le créateur peut modifier
        if ($evenement->user_id !== Auth::id()) {
            return redirect()->route('evenements.index')
                             ->with('erreur', 'Action non autorisée.');
        }

        $request->validate([
            'nom'                     => 'required|string|max:255',
            'description'             => 'required|string',
            'lieu'                    => 'required|string|max:255',
            'categorie'               => 'required|string',
            'date'                    => 'required|date',
            'heure'                   => 'required',
            'nombre_max_participants' => 'required|integer|min:1',
            'image'                   => 'nullable|image|max:2048',
        ]);

        // Gestion de la nouvelle image
        $cheminImage = $evenement->image;
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($evenement->image) {
                Storage::disk('public')->delete($evenement->image);
            }
            $cheminImage = $request->file('image')->store('evenements', 'public');
        }

        $evenement->update([
            'nom'                     => $request->nom,
            'description'             => $request->description,
            'lieu'                    => $request->lieu,
            'categorie'               => $request->categorie,
            'date'                    => $request->date,
            'heure'                   => $request->heure,
            'nombre_max_participants' => $request->nombre_max_participants,
            'image'                   => $cheminImage,
        ]);

        return redirect()->route('evenements.index')
                         ->with('succes', 'Événement modifié avec succès !');
    }

    // Supprimer un événement
    public function supprimer(Evenement $evenement)
    {
        // Seul le créateur peut supprimer
        if ($evenement->user_id !== Auth::id()) {
            return redirect()->route('evenements.index')
                             ->with('erreur', 'Action non autorisée.');
        }

        // Supprimer l'image si elle existe
        if ($evenement->image) {
            Storage::disk('public')->delete($evenement->image);
        }

        $evenement->delete();

        return redirect()->route('evenements.index')->with('succes', 'Événement supprimé avec succès !');
    }
}