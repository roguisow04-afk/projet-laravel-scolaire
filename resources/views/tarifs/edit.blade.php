<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier un tarif</title>

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

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        button {
            margin-top: 15px;
            padding: 10px;
            width: 100%;
            background: orange;
            color: white;
            border: none;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Modifier le tarif</h2>

    {{-- erreurs --}}
    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tarifs.update', $tarif->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nom</label>
        <input type="text" name="nom" value="{{ $tarif->nom }}">

        <label>Montant</label>
        <input type="number" name="montant" value="{{ $tarif->montant }}">

        <label>Classe (non modifiée ici)</label>
        <select disabled>
            @foreach($classes as $classe)
                <option>{{ $classe->nom ?? 'Classe '.$classe->id }}</option>
            @endforeach
        </select>

        <button type="submit">Modifier</button>
    </form>

    <a href="{{ route('tarifs.index') }}">← Retour</a>
</div>

</body>
</html>