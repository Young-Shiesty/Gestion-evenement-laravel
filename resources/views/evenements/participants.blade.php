@extends('layouts.app')
@section('titre', 'Participants')
@section('contenu')
    <a href="{{ route('evenements.afficher', $evenement) }}" class="btn btn-secondary btn-sm mb-4">← Retour</a>
    <h2 class="mb-1">{{ $evenement->nom }}</h2>
    <p class="text-muted mb-4">
        👥 {{ $participants->count() }} / {{ $evenement->nombre_max_participants }} participants inscrits
    </p>
    @if($participants->isEmpty())
        <div class="alert alert-info">
            Aucun participant inscrit pour l'instant.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Inscrit le</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participants as $participant)
                        <tr>
                            <td>{{ $participant->name }}</td>
                            <td>{{ $participant->email }}</td>
{{--La table inscriptions est une table intermédiaire entre users et evenements. pivot permet d'accéder aux colonnes de cette table intermédiaire. --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

@endsection