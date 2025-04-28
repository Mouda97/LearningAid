@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Créer une nouvelle note</h1>
        <p class="text-gray-600">Rédigez votre note et personnalisez ses paramètres</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="titre" class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                    >
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="contenu" class="block text-sm font-medium text-gray-700 mb-1">Contenu</label>
                <textarea name="content" id="content" rows="10" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                    >{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="statut" id="statut" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="brouillon" {{ old('statut') == 'brouillon' ? 'selected' : '' }}>brouillon</option>
                        <option value="publiee" {{ old('statut') == 'publiee' ? 'selected' : '' }}>publiee</option>
                        <option value="archivee" {{ old('statut') == 'archivee' ? 'selected' : '' }}>archivée</option>
                    </select>
                </div>
                
                <div>
                    <label for="niveau_visibilite" class="block text-sm font-medium text-gray-700 mb-1">Visibilité</label>
                    <select name="niveau_visibilite" id="niveau_visibilite" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="prive" {{ old('niveau_visibilite') == 'prive' ? 'selected' : '' }}>privé</option>
                        <option value="groupe" {{ old('niveau_visibilite') == 'groupe' ? 'selected' : '' }}>groupe</option>
                        <option value="public" {{ old('niveau_visibilite') == 'public' ? 'selected' : '' }}>public</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- <div>
                    <label for="categorie" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <input type="text" name="categorie" id="categorie" value="{{ old('categorie') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div> --}}
                
                <div>
                    <label for="matiere" class="block text-sm font-medium text-gray-700 mb-1">Matière</label>
                    <input type="text" name="matiere" id="matiere" value="{{ old('matiere') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="chapitre" class="block text-sm font-medium text-gray-700 mb-1">Chapitre</label>
                    <input type="text" name="chapitre" id="chapitre" value="{{ old('chapitre') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Tags (séparés par des virgules)</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div> --}}
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('notes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Annuler
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection