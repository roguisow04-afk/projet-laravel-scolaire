@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l'année : {{ $annee->anne_ac }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!$annee->estModifiable())
        <div class="alert alert-warning">
            Cette année ne peut plus être modifiée.
        </div>
    @endif

    <form action="{{ route('annee_academique.update', $annee->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="anne_ac" class="form-label">Année académique</label>
            <input type="text" name="anne_ac" class="form-control" value="{{ old('anne_ac', $annee->anne_ac) }}" {{ !$annee->estModifiable() ? 'disabled' : '' }} required>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de début</label>
            <input type="date" name="date_debut" class="form-control" value="{{ old('date_debut', $annee->date_debut->format('Y-m-d')) }}" {{ !$annee->estModifiable() ? 'disabled' : '' }} required>
        </div>

        <div class="mb-3">
            <label for="date_fin" class="form-label">Date de fin</label>
            <input type="date" name="date_fin" class="form-control" value="{{ old('date_fin', $annee->date_fin->format('Y-m-d')) }}" {{ !$annee->estModifiable() ? 'disabled' : '' }} required>
        </div>

        @if($annee->estModifiable())
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        @endif
        <a href="{{ route('annee_academique.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection