<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('titre', 'Événements')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4" style="background: linear-gradient(90deg,#f77754,#f4a261);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('accueil') }}">Events</a>
        <div class="ms-auto d-flex align-items-center gap-4 text-white">
            <a href="{{ route('accueil') }}" class="text-white text-decoration-none">
                <i class="bi bi-house-fill"></i> Home
            </a>
            @auth
            <a href="{{ route('evenements.index') }}" class="text-white text-decoration-none">
            <i class="bi bi-card-text"></i> Evenement</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-light btn-sm">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-white text-decoration-none">
                <i class="bi bi-wifi"></i>Se connecter</a>
                <a href="{{route('register')}}" class="text-white text-decoration-none">S'inscrire</a>
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