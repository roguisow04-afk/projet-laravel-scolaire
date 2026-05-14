@extends('layouts.app')

@section('content')
<h1>Ajouter un nouveau niveau</h1>

<!-- Formulaire pour ajouter un niveau -->
<form action="{{ route('niveaux.store') }}" method="POST">
    @csrf <!-- Protection CSRF -->

    <div>
        <label for="nom_nivaux">Nom du niveau :</label>
        <input type="text" name="nom_nivaux" id="nom_nivaux" value="{{ old('nom_nivaux') }}" required>
    </div>

    <button type="submit">Ajouter</button>
</form>

<!-- Lien pour revenir à la liste -->
<a href="{{ route('niveaux.index') }}" style="display: inline-block; margin-top: 15px;">Retour à la liste des niveaux</a>
@endsection
