@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $note->titre }}</h1>
            <p class="text-gray-600">Créée le {{ $note->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('notes.edit', $note) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                <i class="fas fa-edit mr-1"></i>Modifier
            </a>
            <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    <i class="fas fa-trash mr-1"></i>Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="prose max-w-none">
                {!! nl2br(e($note->contenu)) !!}
            </div>
        </div>
        
        <div class="bg-gray-50 p-6 border-t">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Statut</h3>
                    <p class="mt-1">
                        <span class="px-2 py-1 rounded-full text-xs {{ $note->statut == 'publiee' ? 'bg-green-100 text-green-800' : ($note->statut == 'archivee' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($note->statut) }}
                        </span>
                    </p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Visibilité</h3>
                    <p class="mt-1">{{ ucfirst($note->niveau_visibilite) }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Catégorie</h3>
                    <p class="mt-1">{{ $note->categorie ?: 'Non spécifiée' }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Matière</h3>
                    <p class="mt-1">{{ $note->matiere ?: 'Non spécifiée' }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Chapitre</h3>
                    <p class="mt-1">{{ $note->chapitre ?: 'Non spécifié' }}</p>
                </div>
                
                @if($note->tags)
                <div class="col-span-2 md:col-span-3">
                    <h3 class="text-sm font-medium text-gray-500">Tags</h3>
                    <div class="mt-1 flex flex-wrap gap-2">
                        @foreach(explode(',', $note->tags) as $tag)
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="mt-6">
        <a href="{{ route('notes.index') }}" class="text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-1"></i>Retour à la liste
        </a>
    </div>
</div>
@endsection