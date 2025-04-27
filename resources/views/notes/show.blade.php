@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ $note->titre }}</span>
                    <div>
                        <a href="{{ route('notes.edit', $note) }}" class="btn btn-sm btn-primary">Modifier</a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note?')">Supprimer</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5>Contenu</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($note->contenu)) !!}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Statut:</strong> {{ $note->statut ?? 'Non défini' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Visibilité:</strong> {{ $note->niveau_visibilite ?? 'Non défini' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Catégorie:</strong> {{ $note->categorie ?? 'Non défini' }}
                        </div>
                    </div>

                    <!-- Nouveaux champs ajoutés -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Matière:</strong> {{ $note->matiere ?? 'Non défini' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Chapitre:</strong> {{ $note->chapitre ?? 'Non défini' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Tags:</strong> {{ $note->tags ?? 'Non défini' }}
                        </div>
                    </div>

                    <div class="mt-3">
                        <strong>Créée le:</strong> {{ $note->created_at->format('d/m/Y H:i') }}
                        <br>
                        <strong>Dernière modification:</strong> {{ $note->updated_at->format('d/m/Y H:i') }}
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('notes.index') }}" class="btn btn-secondary">Retour à la liste</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection