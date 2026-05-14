@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Liste des catégories de niveaux</h1>
        <a href="{{ route('categorie_niveaux.create') }}" class="btn btn-success">Ajouter une catégorie</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom de la catégorie</th>
                        <th>Niveau Parent</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categorie_niveaux as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>
                        <td><strong>{{ $cat->categorie_niveau }}</strong></td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $cat->niveau->nom_nivaux ?? 'Non défini' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('categorie_niveaux.edit', $cat->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                            <form action="{{ route('categorie_niveaux.destroy', $cat->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette catégorie ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucune catégorie trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection