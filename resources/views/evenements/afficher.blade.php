@extends('layouts.app')
@section('titre', $evenement->nom)
@section('contenu')
    <a href="{{ route('evenements.index') }}" class="btn btn-secondary btn-sm mb-3">← Retour</a>
    <div class="row">
        <div class="col-md-8">
            @if($evenement->image)
                <img src="{{ asset('storage/' . $evenement->image) }}"
                     class="img-fluid rounded mb-3" style="max-height: 400px; width: 100%; object-fit: cover;">
            @endif
            <span class="badge bg-primary mb-2">{{ $evenement->categorie }}</span>
            <h2>{{ $evenement->nom }}</h2>
            <p class="text-muted">
                📅 {{ $evenement->date }} à {{ $evenement->heure }} &nbsp;|&nbsp; 📍 {{ $evenement->lieu }}
            </p>
            <p>{{ $evenement->description }}</p>
            @auth
                @if(Auth::id() === $evenement->user_id)
                    <a href="{{ route('evenements.editer', $evenement) }}" class="btn btn-warning btn-sm">✏️ Modifier</a>
                    <form method="POST" action="{{ route('evenements.supprimer', $evenement) }}"
                          style="display:inline" onsubmit="return confirm('Supprimer cet événement ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">🗑️ Supprimer</button>
                    </form>
                @endif
            @endauth
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>👥 Participants</h5>
                    <p>{{ $participants->count() }} / {{ $evenement->nombre_max_participants }} inscrits</p>
                    @auth
    @if(Auth::id() !== $evenement->user_id)
        @if($dejaInscrit)
            <p class="text-success">✅ Vous êtes inscrit à cet événement</p>
                <form method="POST" action="{{ route('inscriptions.desinscrire', $evenement) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Se désinscrire</button>
                </form>
                    @else
                        <form method="POST" action="{{ route('inscriptions.inscrire', $evenement) }}">
                        @csrf
                            <button class="btn btn-success btn-sm">S'inscrire</button>
                        </form>
                        @endif
            @endif
                @endauth
            @auth
            @if(Auth::id() === $evenement->user_id)
                <hr>
            <h6>Liste des inscrits :</h6>
            @foreach($participants as $participant)
                <p class="mb-1">👤 {{ $participant->name }}</p>
                @endforeach
                    @if($participants->isEmpty())
                    <p class="text-muted small">Aucun inscrit pour l'instant.</p>
                    @endif
                @endif
                @endauth           
                </div>
            </div>
        </div>
    </div>
@endsection