@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Importer des notes depuis un fichier</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('notes.import-txt') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="file" class="form-label">Fichier TXT</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required>
                            <div class="form-text">Sélectionnez un fichier TXT contenant vos notes.</div>
                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="statut">Statut</label>
                            <select class="form-control @error('statut') is-invalid @enderror" id="statut" name="statut">
                                <option value="nouveau">Nouveau</option>
                                <option value="brouillon">Brouillon</option>
                                <option value="publié">Publié</option>
                            </select>
                            @error('statut')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="niveau_visibilite">Niveau de visibilité</label>
                            <select class="form-control @error('niveau_visibilite') is-invalid @enderror" id="niveau_visibilite" name="niveau_visibilite">
                                <option value="public">Public</option>
                                <option value="privé">Privé</option>
                                <option value="groupe">Groupe</option>
                            </select>
                            @error('niveau_visibilite')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="categorie">Catégorie</label>
                            <input type="text" class="form-control @error('categorie') is-invalid @enderror" id="categorie" name="categorie" value="general">
                            @error('categorie')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="matiere">Matière</label>
                            <input type="text" class="form-control @error('matiere') is-invalid @enderror" id="matiere" name="matiere">
                            @error('matiere')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="chapitre">Chapitre</label>
                            <input type="text" class="form-control @error('chapitre') is-invalid @enderror" id="chapitre" name="chapitre">
                            @error('chapitre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tags">Tags (séparés par des virgules)</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags">
                            @error('tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Importer</button>
                            <a href="{{ route('notes.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection