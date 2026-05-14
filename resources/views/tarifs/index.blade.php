@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Liste des tarifs</h1>
        <a href="{{ route('tarifs.create') }}" class="btn btn-success">Ajouter</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Montant</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($tarifs as $tarif)
                <tr>
                    <td>{{ $tarif->id }}</td>
                    <td>{{ $tarif->nom }}</td>
                    <td>{{ $tarif->montant }} FCFA</td>
                    <td>
                        <a href="{{ route('tarifs.show', $tarif->id) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('tarifs.edit', $tarif->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

</div>
@endsection