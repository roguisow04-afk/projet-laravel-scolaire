@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une classe</h1>

    <form action="{{ route('classes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="code_classe" class="form-label">Code</label>
            <input type="text" name="code_classe" class="form-control" id="code_classe" value="{{ old('code_classe') }}" required>
        </div>

        <div class="mb-3">
            <label for="nom_classe" class="form-label">Nom de la classe</label>
            <input type="text" name="nom_classe" class="form-control" id="nom_classe" value="{{ old('nom_classe') }}" required>
        </div>

        <div class="mb-3">
            <label for="filiere_id" class="form-label">Filière</label>
            <select name="filiere_id" id="filiere_id" class="form-control" required>
                <option value="">-- Choisir une filière --</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                        {{ $filiere->nom_filiere }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="niveau_id" class="form-label">Niveau</label>
            <select name="niveau_id" id="niveau_id" class="form-control" required>
                <option value="">-- Choisir un niveau --</option>
                @foreach($niveaux as $niveau)
                    <option value="{{ $niveau->id }}" {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>
                        {{ $niveau->nom_nivaux }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nouveau champ ajouté ici --}}
        <div class="mb-3">
            <label for="categorie_niveau_id" class="form-label">Catégorie de Niveau</label>
            <select name="categorie_niveau_id" id="categorie_niveau_id" class="form-control" required>
                <option value="">-- Choisir une catégorie --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('categorie_niveau_id') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom_categorie ?? $categorie->libelle }} 
                    </option>
                @endforeach
            </select>
        </div>

         <div class="mb-3">
            <label for="tarif_id" class="form-label">Rattacher un Tarif</label>
            <select name="tarif_id" id="tarif_id" class="form-control">
                <option value="">-- Aucun tarif --</option>
                @foreach($tarifs as $tarif)
                    <option value="{{ $tarif->id }}">{{ $tarif->montant }} FCFA</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>

    <a href="{{ route('classes.index') }}" class="btn btn-secondary mt-2">Retour à la liste</a>
</div>
@endsection