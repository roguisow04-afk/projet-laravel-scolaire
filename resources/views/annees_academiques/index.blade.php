@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Années Académiques</h1>

    <a href="{{ route('annees_academiques.create') }}"
       class="btn btn-success mb-3">
        Ajouter une année
    </a>

    {{-- ================= MESSAGE SUCCESS ================= --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ================= MESSAGE ERROR ================= --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ================= TABLE ================= --}}
    <table class="table table-bordered">

        <thead>
            <tr>
                <th>Année</th>
                <th>Statut</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Ouverture inscription</th>
                <th>Fermeture inscription</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse($annees as $annee)

                <tr>
                    <td>{{ $annee->anne_ac }}</td>
                    <td>{{ ucfirst($annee->statut) }}</td>

                    {{-- protection si date null --}}
                    <td>{{ optional($annee->date_debut)->format('d/m/Y') }}</td>
                    <td>{{ optional($annee->date_fin)->format('d/m/Y') }}</td>

                    <td>{{ optional($annee->ouverture_inscription)->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ optional($annee->fermeture_inscription)->format('d/m/Y') ?? '-' }}</td>

                    <td>

                        <a href="{{ route('annees_academiques.show', $annee->id) }}"
                           class="btn btn-info btn-sm">
                            Voir
                        </a>

                        {{-- Modifier --}}
                        @if($annee->estModifiable())
                            <a href="{{ route('annees_academiques.edit', $annee->id) }}"
                               class="btn btn-primary btn-sm">
                                Modifier
                            </a>
                        @endif

                        {{-- Clôturer --}}
                        @if($annee->peutCloturer())
                            <form action="{{ route('annees_academiques.cloturer', $annee->id) }}"
                                  method="POST"
                                  style="display:inline;">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="btn btn-warning btn-sm"
                                        onclick="return confirm('Clôturer cette année ?')">
                                    Clôturer
                                </button>

                            </form>
                        @endif

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center">
                        Aucune année trouvée.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection