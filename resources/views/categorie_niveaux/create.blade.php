@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Ajouter une catégorie de niveau</h1>
        <a href="{{ route('categorie_niveaux.index') }}" class="btn btn-secondary">← Retour</a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('categorie_niveaux.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="categorie_niveau" class="form-label fw-bold">Nom de la catégorie :</label>
                    <input type="text" name="categorie_niveau" id="categorie_niveau"
                        class="form-control @error('categorie_niveau') is-invalid @enderror"
                        value="{{ old('categorie_niveau') }}"
                        placeholder="Ex: Licence 1, Master 2...">
                    @error('categorie_niveau') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="niveau_id" class="form-label fw-bold">Niveau :</label>
                    <select name="niveau_id" id="niveau_id"
                        class="form-select @error('niveau_id') is-invalid @enderror">
                        <option value="">-- Choisir un niveau --</option>
                        @foreach($niveaux as $niveau)
                            <option value="{{ $niveau->id }}" {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>
                                {{ $niveau->nom_nivaux }}
                            </option>
                        @endforeach
                    </select>
                    @error('niveau_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">💾 Enregistrer la catégorie</button>
            </form>
        </div>
    </div>
</div>
@endsection