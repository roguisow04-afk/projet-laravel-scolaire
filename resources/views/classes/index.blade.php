@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background-color: #5a6268; min-height: 100vh; padding: 20px; color: white;">
    
    <h1 style="font-size: 3rem; font-weight: bold; color: #343a40; margin-bottom: 20px;">Liste des classes</h1>

    <div class="mb-4">
        <a href="{{ route('classes.create') }}" class="btn btn-primary" style="border-radius: 5px; padding: 10px 20px;">
            <i class="fas fa-plus"></i> Ajouter une classe
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background-color: #d4edda; color: #155724; border: none;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered bg-white" style="border-radius: 5px; overflow: hidden;">
            <thead class="thead-light">
                <tr style="font-weight: bold;">
                    <th>ID</th>
                    <th>Code</th>
                    <th>Nom classe</th>
                    <th>Filière</th>
                    <th>Niveau</th>
                    <th>CategorieNivaux</th>
                    <th>Tarif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $classe)
                <tr>
                    <td>{{ $classe->id }}</td>
                    <td>{{ $classe->code_classe }}</td>
                    <td>{{ $classe->nom_classe }}</td>
                    <td>{{ $classe->filiere->nom_filiere ?? '-' }}</td>
                    <td>{{ $classe->niveau->nom_nivaux ?? '-' }}</td>
                    <td>{{ $classe->CategorieNivaux->code ?? '-' }}</td>
                    <td>{{ $classe->Tarif->code ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('classes.edit', $classe->id) }}" class="btn btn-warning btn-sm" style="color: black; font-weight: bold;">
                                Modifier
                            </a>
                            
                            <form action="{{ route('classes.destroy', $classe->id) }}" method="POST" onsubmit="return confirm('Supprimer cette classe ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="font-weight: bold;">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection