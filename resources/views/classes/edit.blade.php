@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifier la classe : {{ $classe->nom_classe }}</h1>

    {{-- Affichage des erreurs de validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CORRECTION CRUCIALE : Utilisation de l'URL directe pour éviter l'erreur de paramètre manquant --}}
    <form action="/classes/{{ $classe->id }}" method="POST">
        @csrf
        @method('PUT') 
        
        <!-- Nom de la classe -->
        <div class="mb-3">
            <label for="nom_classe" class="form-label">Nom de la classe</label>
            <input type="text" name="nom_classe" id="nom_classe"
                   class="form-control"
                   value="{{ old('nom_classe', $classe->nom_classe) }}" required>
        </div>

        <!-- Code de la classe -->
        <div class="mb-3">
            <label for="code_classe" class="form-label">Code de la classe</label>
            <input type="text" name="code_classe" id="code_classe"
                   class="form-control"
                   value="{{ old('code_classe', $classe->code_classe) }}" required>
        </div>

        <!-- Sélect Niveau -->
        <div class="mb-3">
            <label for="niveau_id" class="form-label">Niveau</label>
            <select name="niveau_id" id="niveau_id" class="form-select" required>
                <option value="">-- Choisir un niveau --</option>
                @foreach($niveaux as $niveau)
                    <option value="{{ $niveau->id }}"
                        {{ old('niveau_id', $classe->niveau_id) == $niveau->id ? 'selected' : '' }}>
                        {{ $niveau->nom_nivaux }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sélect Filière -->
        <div class="mb-3">
            <label for="filiere_id" class="form-label">Filière</label>
            <select name="filiere_id" id="filiere_id" class="form-select" required>
                <option value="">-- Choisir une filière --</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}"
                        {{ old('filiere_id', $classe->filiere_id) == $filiere->id ? 'selected' : '' }}>
                        {{ $filiere->nom_filiere }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sélect Catégorie Niveau -->
        <div class="mb-3">
            <label for="categorie_niveau_id" class="form-label">Catégorie Niveau</label>
            <select name="categorie_niveau_id" id="categorie_niveau_id" class="form-select" required>
                <option value="">-- Choisir une catégorie --</option>
                @foreach($categorieNiveaux as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('categorie_niveau_id', $classe->categorie_niveau_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nom_categorie }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Boutons d'action -->
        <div class="mt-4">
            <button type="submit" class="btn btn-success">💾 Mettre à jour</button>
            <a href="{{ route('classes.index') }}" class="btn btn-secondary ms-2">Annuler</a>
        </div>

    </form> 
</div>
@endsection