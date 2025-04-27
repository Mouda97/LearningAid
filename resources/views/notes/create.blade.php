@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Créer une nouvelle note</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('notes.store') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="titre">Titre</label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required>
                            @error('titre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="contenu">Contenu</label>
                            <textarea class="form-control @error('contenu') is-invalid @enderror" id="contenu" name="contenu" rows="10" required>{{ old('contenu') }}</textarea>
                            @error('contenu')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="statut">Statut</label>
                            <select class="form-control @error('statut') is-invalid @enderror" id="statut" name="statut">
                                <option value="brouillon" {{ old('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                                <option value="publié" {{ old('statut') == 'publié' ? 'selected' : '' }}>Publié</option>
                                <option value="archivé" {{ old('statut') == 'archivé' ? 'selected' : '' }}>Archivé</option>
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
                                <option value="privé" {{ old('niveau_visibilite') == 'privé' ? 'selected' : '' }}>Privé</option>
                                <option value="public" {{ old('niveau_visibilite') == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="groupe" {{ old('niveau_visibilite') == 'groupe' ? 'selected' : '' }}>Groupe</option>
                            </select>
                            @error('niveau_visibilite')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="categorie">Catégorie</label>
                            <input type="text" class="form-control @error('categorie') is-invalid @enderror" id="categorie" name="categorie" value="{{ old('categorie') }}">
                            @error('categorie')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Nouveaux champs ajoutés -->
                        <div class="form-group mb-3">
                            <label for="matiere">Matière</label>
                            <input type="text" class="form-control @error('matiere') is-invalid @enderror" id="matiere" name="matiere" value="{{ old('matiere') }}">
                            @error('matiere')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="chapitre">Chapitre</label>
                            <input type="text" class="form-control @error('chapitre') is-invalid @enderror" id="chapitre" name="chapitre" value="{{ old('chapitre') }}">
                            @error('chapitre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tags">Tags (séparés par des virgules)</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}">
                            @error('tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Créer la note</button>
                            <a href="{{ route('notes.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection