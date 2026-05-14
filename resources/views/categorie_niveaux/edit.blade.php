@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Modifier la catégorie de niveau</h1>
        <a href="{{ route('categorie_niveaux.index') }}" class="btn btn-secondary">← Retour</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            {{-- ✅ Clé primaire correcte : id --}}
            <form action="{{ route('categorie_niveaux.update', $categorie_niveau->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="categorie_niveau" class="form-label fw-bold">Nom de la catégorie :</label>
                    <input type="text" name="categorie_niveau" id="categorie_niveau"
                        class="form-control @error('categorie_niveau') is-invalid @enderror"
                        value="{{ old('categorie_niveau', $categorie_niveau->categorie_niveau) }}">
                    @error('categorie_niveau') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="niveau_id" class="form-label fw-bold">Niveau :</label>
                    <select name="niveau_id" id="niveau_id"
                        class="form-select @error('niveau_id') is-invalid @enderror">
                        <option value="">-- Choisir un niveau --</option>
                        @foreach($niveaux as $niveau)
                            <option value="{{ $niveau->id }}"
                                {{ old('niveau_id', $categorie_niveau->niveau_id) == $niveau->id ? 'selected' : '' }}>
                                {{ $niveau->nom_nivaux }}
                            </option>
                        @endforeach
                    </select>
                    @error('niveau_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
            </form>
        </div>
    </div>

</div>
@endsection