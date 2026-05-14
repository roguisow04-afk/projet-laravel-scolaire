@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer une nouvelle classe</h1>

    {{-- Affichage des erreurs de validation --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire de création --}}
    <form action="{{ route('classes.store') }}" method="POST">
        @csrf

        {{-- Nom de la classe --}}
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la classe :</label>
            <input type="text" name="nom" id="nom" class="form-control" 
                   value="{{ old('nom') }}" required>
        </div>

        {{-- Niveau --}}
        <div class="mb-3">
            <label for="niveau_id" class="form-label">Niveau :</label>
            <select name="niveau_id" id="niveau_id" class="form-select" required>
                <option value="">-- Choisir un niveau --</option>
                @if(isset($niveaux))
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" 
                            {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>
                            {{ $niveau->nom_nivaux }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- Filière --}}
        <div class="mb-3">
            <label for="filiere_id" class="form-label">Filière :</label>
            <select name="filiere_id" id="filiere_id" class="form-select" required>
                <option value="">-- Choisir une filière --</option>
                @if(isset($filieres))
                    @foreach($filieres as $filiere)
                        <option value="{{ $filiere->id }}" 
                            {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                            {{ $filiere->nom_filiere }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- Catégorie de niveau --}}
        <div class="mb-3">
            <label for="categorie_niveau_id" class="form-label">Catégorie :</label>
            <select name="categorie_niveau_id" id="categorie_niveau_id" class="form-select" required>
                <option value="">-- Choisir une catégorie --</option>
                @if(isset($categorieNiveaux))
                    @foreach($categorieNiveaux as $categorie)
                        <option value="{{ $categorie->id }}" 
                            {{ old('categorie_niveau_id') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom_categorie }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- Bouton soumettre --}}
        <button type="submit" class="btn btn-primary">💾 Créer la classe</button>
    </form>
</div>
@endsection