@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Mes notes</span>
                    <div>
                        <a href="{{ route('notes.create') }}" class="btn btn-sm btn-primary me-2">Nouvelle note</a>
                        <a href="{{ url('/notes/import') }}" class="btn btn-sm btn-success">Importer TXT</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($notes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Statut</th>
                                        <th>Visibilité</th>
                                        <th>Catégorie</th>
                                        <th>Matière</th>
                                        <th>Chapitre</th>
                                        <th>Date de création</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notes as $note)
                                        <tr>
                                            <td>
                                                <a href="{{ route('notes.show', $note) }}">{{ $note->titre }}</a>
                                            </td>
                                            <td>{{ $note->statut ?? 'Non défini' }}</td>
                                            <td>{{ $note->niveau_visibilite ?? 'Non défini' }}</td>
                                            <td>{{ $note->categorie ?? 'Non défini' }}</td>
                                            <td>{{ $note->matiere ?? 'Non défini' }}</td>
                                            <td>{{ $note->chapitre ?? 'Non défini' }}</td>
                                            <td>{{ $note->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('notes.edit', $note) }}" class="btn btn-sm btn-info">Modifier</a>
                                                <form action="{{ route('notes.destroy', $note) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note?')">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $notes->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            Vous n'avez pas encore créé de notes. <a href="{{ route('notes.create') }}">Créez votre première note</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection