@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la classe</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('classes.update', $classe->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nom de la classe --}}
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la classe</label>
            <input type="text" name="nom" id="nom"
                   class="form-control"
                   value="{{ old('nom', $classe->nom) }}" required>
        </div>

        {{-- Niveau --}}
        <div class="mb-3">
            <label for="niveau_id" class="form-label">Niveau</label>
            <select name="niveau_id" id="niveau_id" class="form-select" required>
                <option value="">-- Choisir un niveau --</option>
                @foreach($niveaux as $niveau)
                    <option value="{{ $niveau->id }}" {{ old('niveau_id', $classe->niveau_id) == $niveau->id ? 'selected' : '' }}>
                        {{ $niveau->nom_niveau }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filière --}}
        <div class="mb-3">
            <label for="filiere_id" class="form-label">Filière</label>
            <select name="filiere_id" id="filiere_id" class="form-select" required>
                <option value="">-- Choisir une filière --</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ old('filiere_id', $classe->filiere_id) == $filiere->id ? 'selected' : '' }}>
                        {{ $filiere->nom_filiere }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Catégorie de niveau --}}
        <div class="mb-3">
            <label for="categorie_niveau_id" class="form-label">Catégorie de niveau</label>
            <select name="categorie_niveau_id" id="categorie_niveau_id" class="form-select" required>
                <option value="">-- Choisir une catégorie --</option>
                @foreach($categorieNiveaux as $cat)
                    <option value="{{ $cat->id }}" {{ old('categorie_niveau_id', $classe->categorie_niveau_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nom_categorie }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
    </form>
</div>
@endsection