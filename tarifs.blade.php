<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des tarifs</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        hr {
            margin: 30px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #007bff;
            color: white;
            padding: 10px;
        }

        td {
            padding: 8px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #b02a37;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Créer / Modifier un tarif</h2>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('tarifs.store') }}">
        @csrf
        <input type="hidden" name="tarif_id" id="tarif_id">

        <label>Nom :</label>
        <input type="text" name="nom" required>

        <label>Inscription :</label>
        <input type="number" name="inscription" required>

        <label>Mensualité :</label>
        <input type="number" name="mensualite" required>

        <label>Classe :</label>
        <select name="classe_id">
            <option value="">-- choisir une classe --</option>
            @foreach($classes as $classe)
                <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
            @endforeach
        </select>

        <button type="submit">💾 Enregistrer</button>
    </form>

    <hr>

    <h2>Liste des tarifs</h2>

    <table>
        <tr>
            <th>Nom</th>
            <th>Inscription</th>
            <th>Mensualité</th>
            <th>Classe</th>
            <th>Actif</th>
            <th>Action</th>
        </tr>

        @foreach($tarifs as $tarif)
            <tr>
                <td>{{ $tarif->nom }}</td>
                <td>{{ $tarif->inscription }}</td>
                <td>{{ $tarif->mensualite }}</td>
                <td>{{ $tarif->classe->nom ?? 'Aucune' }}</td>
                <td>{{ $tarif->actif ? 'Oui' : 'Non' }}</td>
                <td>
                    <form action="{{ route('tarifs.destroy',$tarif->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn" onclick="return confirm('Supprimer ?')">🗑 Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

</div>

</body>
</html>