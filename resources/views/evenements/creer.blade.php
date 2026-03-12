@extends('layouts.app')

@section('titre', 'Créer un événement')

@section('contenu')

    <div style="max-width: 700px; margin: auto;">

        <h2 class="mb-3">Créer un événement</h2>
        <a href="{{ route('evenements.index') }}" class="btn btn-secondary btn-sm mb-3">← Retour</a>

        <form method="POST" action="{{ route('evenements.sauvegarder') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nom de l'événement</label>
                <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Heure</label>
                    <input type="time" name="heure" class="form-control" value="{{ old('heure') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Lieu</label>
                <input type="text" name="lieu" class="form-control" value="{{ old('lieu') }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie" class="form-select" required>
                        <option value="">Choisir...</option>
                        <option value="sport">Sport</option>
                        <option value="culture">Culture</option>
                        <option value="formation">Formation</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre max de participants</label>
                    <input type="number" name="nombre_max_participants"
                           class="form-control" value="{{ old('nombre_max_participants') }}" min="1" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Image (optionnelle)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-success w-100">Créer l'événement</button>
        </form>

    </div>

@endsection