<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('titre', 'Événements')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('evenements.index') }}">🎉Events</a>
        <div class="ms-auto d-flex gap-2">
            @auth
                <a href="{{ route('evenements.creer') }}" class="btn btn-success btn-sm">+ Créer un événement</a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                    <button class="btn btn-outline-light btn-sm">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-light btn-sm">Inscription</a>
            @endauth
        </div>
    </div>
</nav>
<div class="container">
    @if(session('succes'))
        <div class="alert alert-success">{{ session('succes') }}</div>
    @endif
    @if(session('erreur'))
        <div class="alert alert-danger">{{ session('erreur') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('contenu')
</div>

</body>
</html>