@extends('layouts.app')

@section('content')
<h1>Modifier le niveau</h1>

<!-- Formulaire pour modifier un niveau -->
<form action="{{ route('niveaux.update', $niveau->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Indique à Laravel que c'est une mise à jour -->

    <div>
        <label for="nom_nivaux">Nom du niveau :</label>
        <input type="text" name="nom_nivaux" id="nom_nivaux" value="{{ old('nom_nivaux', $niveau->nom_nivaux) }}" required>
    </div>

    <button type="submit">Mettre à jour</button>
</form>

<!-- Lien pour revenir à la liste -->
<a href="{{ route('niveaux.index') }}" style="display: inline-block; margin-top: 15px;">Retour à la liste des niveaux</a>
@endsection
