@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Créer un tarif</h1>
        <a href="{{ route('tarifs.index') }}" class="btn btn-secondary">← Retour à la liste</a>
    </div>

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

            <form action="{{ route('tarifs.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Nom du tarif</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Montant (FCFA)</label>
                    <input type="number" name="montant" class="form-control" value="{{ old('montant') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Classe</label>
                    <select name="classe_id" class="form-select">
                        <option value="">-- Choisir --</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">💾 Enregistrer</button>

            </form>

        </div>
    </div>

</div>
@endsection