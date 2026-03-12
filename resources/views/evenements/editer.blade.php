@extends('layouts.app')

@section('titre', 'Modifier l\'événement')

@section('contenu')
    <div style="max-width:700px; margin:auto;">

        <h2 class="mb-3">Modifier l'événement</h2>
        <a href="{{ route('evenements.afficher', $evenement) }}" class="btn btn-secondary btn-sm mb-3">← Retour</a>

        <form method="POST" action="{{ route('evenements.mettreAJour', $evenement) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nom de l'événement</label>
                <input type="text" name="nom" class="form-control" value="{{ old('nom', $evenement->nom) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description', $evenement->description) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $evenement->date) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Heure</label>
                    <input type="time" name="heure" class="form-control" value="{{ old('heure', $evenement->heure) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Lieu</label>
                <input type="text" name="lieu" class="form-control" value="{{ old('lieu', $evenement->lieu) }}" required>
            </div>

            <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Catégorie</label>
                <select name="categorie" class="form-select" required>
                    <option value="sport" @if($evenement->categorie == 'sport') selected @endif>Sport</option>
                    <option value="culture" @if($evenement->categorie == 'culture') selected @endif>Culture</option>
                    <option value="formation" @if($evenement->categorie == 'formation') selected @endif>Formation</option>
                    <option value="autre" @if($evenement->categorie == 'autre') selected @endif>Autre</option>
                </select>
            </div>
              <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre max de participants</label>
                    <input type="number" name="nombre_max_participants" class="form-control"
                           value="{{ old('nombre_max_participants', $evenement->nombre_max_participants) }}" min="1" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Image</label>@if($evenement->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $evenement->image) }}"
                             style="height: 100px; object-fit: cover;" class="rounded">
                        <p class="small text-muted">Image actuelle</p>
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Laisse vide pour garder l'image actuelle</small>
            </div>

            <button type="submit" class="btn btn-warning w-100">Sauvegarder les modifications</button>
        </form>

    </div>

@endsection