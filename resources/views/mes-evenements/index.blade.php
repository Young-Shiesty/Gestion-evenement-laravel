@extends('layouts.app')
@section('titre', 'Mes Événements')
@section('contenu')
    <h2 class="mb-4">Mes Événements</h2>
    <h4>Événements que j'ai créés</h4>
    @if($mesEvenements->isEmpty())
        <p class="text-muted">Vous n'avez pas encore créé d'événement.</p>
    @else
        <div class="row mb-5">
            @foreach($mesEvenements as $evenement)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        @if($evenement->image)
                            <img src="{{ asset('storage/' . $evenement->image) }}"
                            class="card-img-top" style="height: 200px; object-fit: cover;">
                        @else
                             <p>Pas d'image</p>
                        @endif
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">{{ $evenement->categorie }}</span>
                            <h5 class="card-title">{{ $evenement->nom }}</h5>
                            <p class="text-muted small">
                                📅 {{ $evenement->date }} à {{ $evenement->heure }}<br>
                                📍 {{ $evenement->lieu }}<br>
                                👥 {{ $evenement->inscriptions->count() }} / {{ $evenement->nombre_max_participants }} participants
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('evenements.afficher', $evenement) }}"
                                   class="btn btn-outline-primary btn-sm">Voir</a>
                                <a href="{{ route('evenements.editer', $evenement) }}"
                                   class="btn btn-warning btn-sm">Modifier</a>
                                <form method="POST" action="{{ route('evenements.supprimer', $evenement) }}"
                                      onsubmit="return confirm('Supprimer cet événement ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <hr class="mb-4">
    <h4>Événements auxquels je suis inscrit</h4>
    @if($mesInscriptions->isEmpty())
        <p class="text-muted">Vous n'êtes inscrit à aucun événement.</p>
    @else
        <div class="row">
            @foreach($mesInscriptions as $inscription)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        @if($inscription->evenement->image)
                            <img src="{{ asset('storage/' . $inscription->evenement->image) }}"
                                 class="card-img-top" style="height: 180px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <span class="badge bg-success mb-2">{{ $inscription->evenement->categorie }}</span>
                            <h5 class="card-title">{{ $inscription->evenement->nom }}</h5>
                            <p class="text-muted small">
                                📅 {{ $inscription->evenement->date }} à {{ $inscription->evenement->heure }}<br>
                                📍 {{ $inscription->evenement->lieu }}
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('evenements.afficher', $inscription->evenement) }}"
                                   class="btn btn-outline-primary btn-sm">Voir</a>
                                <form method="POST" action="{{ route('inscriptions.desinscrire', $inscription->evenement) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Se désinscrire</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection