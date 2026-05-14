<!DOCTYPE html>
<html>
<head>
    <title>Détail filière</title>
</head>
<body>
    <h1>Détail de la filière</h1>

    <p><strong>Code :</strong> {{ $filiere->code }}</p>
    <p><strong>Nom :</strong> {{ $filiere->nom_filiere }}</p>

    <a href="{{ route('filieres.index') }}">⬅ Retour</a>
</body>
</html>
