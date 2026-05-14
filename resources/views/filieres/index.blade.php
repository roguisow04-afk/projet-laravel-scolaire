@extends('layouts.app')

@section('content')
<h1>Liste des filières</h1>

<a href="{{ route('filieres.create') }}" class="btn btn-primary mb-3">Ajouter une filière</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Nom de la filière</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($filieres as $filiere)
        <tr>
            <td>{{ $filiere->id}}</td>
            <td>{{ $filiere->code}}</td>
            <td>{{ $filiere->nom_filiere }}</td>
            <td>
                <a href="{{ route('filieres.edit', $filiere->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('filieres.destroy', $filiere->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette filière ?')" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
