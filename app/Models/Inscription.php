<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = [
        'user_id',
        'evenement_id',
    ];

    // Une inscription appartient a un utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(User::class);
    }

    // Une inscription appartient a un evenement
    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }
}