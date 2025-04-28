@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Importer des notes</h1>
        <p class="text-gray-600">Importez vos notes depuis un fichier texte</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('notes.import-txt') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Fichier TXT</label>
                <input type="file" name="file" id="file" accept=".txt,.pdf,.doc,.docx" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                    required>
                <p class="text-sm text-gray-500 mt-1">Formats acceptés : TXT, PDF, DOC, DOCX</p>
                @error('file')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Seuls les fichiers .txt sont acceptés</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="statut" id="statut" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="brouillon">Brouillon</option>
                        <option value="publiee">Publiée</option>
                    </select>
                </div>
                
                <div>
                    <label for="niveau_visibilite" class="block text-sm font-medium text-gray-700 mb-1">Visibilité</label>
                    <select name="niveau_visibilite" id="niveau_visibilite" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="prive">Privé</option>
                        <option value="groupe">Groupe</option>
                        <option value="public">Public</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="categorie" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <input type="text" name="categorie" id="categorie" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="matiere" class="block text-sm font-medium text-gray-700 mb-1">Matière</label>
                    <input type="text" name="matiere" id="matiere" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="chapitre" class="block text-sm font-medium text-gray-700 mb-1">Chapitre</label>
                    <input type="text" name="chapitre" id="chapitre" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Tags (séparés par des virgules)</label>
                    <input type="text" name="tags" id="tags" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('notes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Annuler
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Importer
                </button>
            </div>
        </form>
    </div>
    
    <div class="mt-6 bg-blue-50 p-4 rounded-lg border border-blue-200">
        <h3 class="text-lg font-medium text-blue-800 mb-2">Conseils pour l'importation</h3>
        <ul class="list-disc pl-5 text-blue-700 space-y-1">
            <li>La première ligne du fichier sera utilisée comme titre de la note</li>
            <li>Le reste du contenu sera importé tel quel</li>
            <li>Assurez-vous que votre fichier est encodé en UTF-8 pour éviter les problèmes d'accents</li>
        </ul>
    </div>
</div>
@endsection