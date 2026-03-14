<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\Inscription;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    public function inscrire(Evenement $evenement)
    {
        $nombreInscrits = $evenement->inscriptions->count();
        if ($nombreInscrits >= $evenement->nombre_max_participants) {
            return redirect()->route('evenements.afficher', $evenement)
        ->with('erreur', 'Cet événement est complet.');
        }
        $dejaInscrit = Inscription::where('user_id', Auth::id())
        ->where('evenement_id', $evenement->id)->first();

        if ($dejaInscrit != null){
            return redirect()->route('evenements.afficher', $evenement)
            ->with('erreur', 'Vous êtes déjà inscrit à cet événement.');
        }
        Inscription::create([
            'user_id'      => Auth::id(),
            'evenement_id' => $evenement->id,
        ]);
        return redirect()->route('evenements.afficher', $evenement)
        ->with('succes', 'Inscription réussie !');
    }
    public function desinscrire(Evenement $evenement)
    {
        $inscription = Inscription::where('user_id', Auth::id())
        ->where('evenement_id', $evenement->id)->first();
        if ($inscription) {
            $inscription->delete();
        }
        return redirect()->route('evenements.afficher', $evenement)->with('succes', 'Désinscription réussie.');
    }
   
 
}
