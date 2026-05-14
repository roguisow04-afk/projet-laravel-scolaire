<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Détail du tarif</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 20px;
        }

        .box {
            width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        h2 {
            text-align: center;
        }

        a {
            display: inline-block;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Détail du tarif</h2>

    <p><strong>Nom :</strong> {{ $tarif->nom }}</p>
    <p><strong>Montant :</strong> {{ $tarif->montant }}</p>

    <h3>Classes liées :</h3>

    @if($tarif->classes->count())
        <ul>
            @foreach($tarif->classes as $classe)
                <li>{{ $classe->nom ?? 'Classe '.$classe->id }}</li>
            @endforeach
        </ul>
    @else
        <p>Aucune classe liée</p>
    @endif

    <a href="{{ route('tarifs.index') }}">← Retour</a>
</div>

</body>
</html>