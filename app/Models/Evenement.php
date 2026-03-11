<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    // Les champs qu'on peut remplir
    protected $fillable = [
        'user_id',
        'nom',
        'description',
        'lieu',
        'categorie',
        'date',
        'heure',
        'nombre_max_participants',
        'image',
    ];

    // Un evenement appartient a un utilisateur 
    public function createur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Un evenement a plusieurs inscriptions
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    // Un evenement a plusieurs participants 
    public function participants()
    {
        return $this->belongsToMany(User::class, 'inscriptions');
    }
}