@extends('layouts.app')

@section('content')
<h1>Ajouter une filière</h1>

<form action="{{ route('filieres.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="code" class="form-label">Code</label>
        <input type="text" name="code" class="form-control" id="code" value="{{ old('code') }}" required>
    </div>
    <div class="mb-3">
        <label for="nom_filiere" class="form-label">Nom de la filière</label>
        <input type="text" name="nom_filiere" class="form-control" id="nom_filiere" value="{{ old('nom_filiere') }}" required>
    </div>
    <button type="submit" class="btn btn-success">Ajouter</button>
</form>

<a href="{{ route('filieres.index') }}" class="btn btn-secondary mt-2">Retour à la liste</a>
@endsection
