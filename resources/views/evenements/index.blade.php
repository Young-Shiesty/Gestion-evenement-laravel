@extends('layouts.app')
@section('titre', 'Liste des événements')
@section('contenu')
    <form method="GET" action="{{ route('evenements.index') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <input type="text" name="recherche" class="form-control"
                   placeholder="Rechercher..." value="{{ request('recherche') }}">
        </div>
        <div class="col-md-3">
          <select name="categorie" class="form-select">
                <option value="">Toutes les catégories</option>
                <option value="sport"@if(request('categorie')=='sport') selected @endif>Sport</option>
                <option value="culture"@if(request('categorie') == 'culture')   selected @endif>Culture</option>
                <option value="formation"@if(request('categorie') == 'formation') selected @endif>Formation</option>
                <option value="autre"@if(request('categorie') == 'autre')     selected @endif>Autre</option>
          </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="lieu" class="form-control" placeholder="Lieu" value="{{ request('lieu') }}">
        </div>
        <div class="col-md-2">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrer</button>
        </div>
    </form>
    <div class="row">
        @foreach($evenements as $evenement)
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="{{ asset('storage/' . $evenement->image) }}"
                            class="card-img-top" style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <h5>{{ $evenement->nom }}</h5>
                <p>📅 {{ $evenement->date }} à {{ $evenement->heure }}</p>
                <p>📍 {{ $evenement->lieu }}</p>
                <p>Catégorie : {{ $evenement->categorie }}</p>
                <p>Participants : {{ $evenement->inscriptions->count() }} / {{ $evenement->nombre_max_participants }}</p>
                <a href="{{ route('evenements.afficher', $evenement) }}" class="btn btn-primary">
                    Voir détails
                </a>
            </div>
        </div>
    </div>
@endforeach
@if($evenements->isEmpty())
    <p>Aucun événement trouvé.</p>
@endif
    </div>

@endsection