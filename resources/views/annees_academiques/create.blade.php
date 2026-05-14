@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une Année Académique</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('annees_academiques.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="anne_ac" class="form-label">Année académique</label>
            <input type="text" name="anne_ac" class="form-control" value="{{ old('anne_ac') }}" placeholder="Ex: 2025-2026" required>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de début</label>
            <input type="date" name="date_debut" class="form-control" value="{{ old('date_debut') }}" required>
        </div>

        <div class="mb-3">
            <label for="date_fin" class="form-label">Date de fin</label>
            <input type="date" name="date_fin" class="form-control" value="{{ old('date_fin') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Créer</button>
        <a href="{{ route('annees_academiques.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection