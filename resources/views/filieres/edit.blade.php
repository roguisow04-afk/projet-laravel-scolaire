@extends('layouts.app')

@section('content')
<h1>Modifier la filière</h1>

<form action="{{ route('filieres.update', $filiere->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="code" class="form-label">Code</label>
        <input type="text" name="code" class="form-control" id="code" value="{{ old('code', $filiere->code) }}" required>
    </div>
    <div class="mb-3">
        <label for="nom_filiere" class="form-label">Nom de la filière</label>
        <input type="text" name="nom_filiere" class="form-control" id="nom_filiere" value="{{ old('nom_filiere', $filiere->nom_filiere) }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>

<a href="{{ route('filieres.index') }}" class="btn btn-secondary mt-2">Retour à la liste</a>
@endsection
