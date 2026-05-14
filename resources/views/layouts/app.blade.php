<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Scolarité</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 220px;
            background-color: #312828;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
        }
        .sidebar a:hover {
            background-color: #0bd752;
        }
        .content {
            flex: 1;
            padding: 20px;
            background-color: #6f777e;
        }
        .header {
            background-color: #d7dde6;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-center py-3">🎓 Scolarité</h4>
        <a href="{{ route('filieres.index') }}">Filière</a>
        <a href="{{ route('niveaux.index') }}">Niveau</a>
        <a href="{{ route('classes.index') }}">Classe</a>
        <a href="{{ route('tarifs.index') }}">Tarif</a>
        <a href="{{ route('classe_tarif.index') }}">Tarif Classe</a>
        <a href="{{ route('annees_academiques.index') }}">Année Académique</a>
        <a href="{{ route('categorie_niveaux.index') }}">Categorie Niveau</a>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>