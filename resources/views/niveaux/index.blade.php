@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Liste des niveaux</h1>
    <a href="{{ route('niveaux.create') }}" class="btn btn-success">Ajouter un nouveau niveau</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom du niveau</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($niveaux as $niveau)
        <tr>
            <td>{{ $niveau->id }}</td>
            <td>{{ $niveau->nom_nivaux }}</td>
            <td>
                <a href="{{ route('niveaux.edit', $niveau->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                <form action="{{ route('niveaux.destroy', $niveau->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce niveau ?')">Supprimer</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">Aucun niveau trouvé.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection