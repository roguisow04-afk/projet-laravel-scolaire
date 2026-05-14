@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tarifs par classe</h1>
    <a href="{{ route('classe_tarif.create') }}" class="btn btn-success mb-3">Ajouter un tarif</a>

    <!-- Messages flash -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Classe</th>
                <th>Tarif actif</th>
                <th>Historique des tarifs</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $classe)
                <tr>
                    <td>{{ $classe->nom }}</td>

                    <!-- Tarif actif -->
                    <td>
                        @if($classe->tarifActif)
                            {{ $classe->tarifActif->nom }} 
                            ({{ number_format($classe->tarifActif->montant, 0, ',', ' ') }} FCFA)
                        @else
                            Aucun
                        @endif
                    </td>

                    <!-- Historique des tarifs -->
                    <td>
                        @foreach($classe->tarifs as $tarif)
                            <div>
                                {{ $tarif->nom }} - {{ number_format($tarif->montant, 0, ',', ' ') }} FCFA
                                @if($tarif->pivot->actif)
                                    <span class="badge bg-success">Actif</span>
                                @endif
                            </div>
                        @endforeach
                    </td>

                    <!-- Actions -->
                    <td>
                        @foreach($classe->tarifs as $tarif)
                            <form action="{{ route('classe_tarif.destroy', ['classe_id' => $classe->id, 'tarif_id' => $tarif->id]) }}" 
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Voulez-vous vraiment supprimer ce tarif ?')">
                                    Supprimer
                                </button>
                            </form>
                        @endforeach
                    </td>
                </tr>
            @endforeach

            @if($classes->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">Aucune classe trouvée.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection