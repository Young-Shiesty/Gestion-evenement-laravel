@extends('layouts.app')

@section('titre', 'Bienvenue')

@section('contenu')

<div class="text-center py-5" style="
    background-image: url('{{ asset('image/auto.webp') }}');
    background-size: cover;
    border-radius: 8px;
    padding: 80px 20px;">
    <div style="background: rgba(0,0,0,0.5); padding: 110px; border-radius:8px; display: inline-block; width: 100%;">
        <h1 class="display-4 fw-bold text-white">Bienvenue sur Events</h1>
        <p class="lead text-white mt-3">
            Découvrez, créez et participez à des événements communautaires près de chez vous.
        </p>
        <div class="mt-4 d-flex justify-content-center gap-3">
            <a href="{{ route('evenements.index') }}" class="btn btn-primary btn-lg">
                Voir les événements
            </a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-success btn-lg">Créer un compte</a>
            @endguest
            @auth
                <a href="{{ route('evenements.creer') }}" class="btn btn-success btn-lg">+ Créer un événement</a>
            @endauth
        </div>
    </div>
</div>
    <hr class="my-5">
    <h4 class="mb-4">Événements récents</h4>
<div class="row">
    @foreach($evenements as $evenement)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                @if($evenement->image)
                    <img src="{{ asset('storage/' . $evenement->image) }}"
                         class="card-img-top" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-secondary text-white text-center py-5">Pas d'image</div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $evenement->nom }}</h5>
                    <p class="text-muted small">{{ $evenement->description }}</p>
                    <p class="text-muted small">📅 {{ $evenement->date }} à {{ $evenement->heure }}</p>
                    <p class="text-muted small">📍 {{ $evenement->lieu }}</p>
                    <a href="{{ route('evenements.afficher', $evenement) }}"
                       class="btn btn-outline-primary btn-sm w-100">Voir l'événement</a>
                </div>

            </div>
        </div>
    @endforeach
</div>

@endsection