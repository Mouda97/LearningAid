@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Flashcards</h1>
        <div class="space-x-2">
            <a href="{{ route('flashcards.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition">
                + Créer des Flashcards
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <!-- Filtres -->
    <div class="flex space-x-2 mb-6">
        <button class="px-4 py-2 bg-gray-100 rounded-full text-gray-700 font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 active">
            Toutes
        </button>
        <button class="px-4 py-2 bg-gray-100 rounded-full text-gray-700 font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Non révisées
        </button>
        <button class="px-4 py-2 bg-gray-100 rounded-full text-gray-700 font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Révisées
        </button>
    </div>

    <!-- Liste des jeux de flashcards -->
    @if($flashcardSets->isEmpty())
    <div class="bg-gray-100 rounded-lg p-8 text-center mb-8">
        <p class="text-gray-600 text-lg">Vous n'avez pas encore de flashcards. Commencez par en créer !</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach($flashcardSets as $set)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden border border-gray-200">
            <!-- Barre colorée en haut de la carte -->
            <div class="h-2 w-full 
                @if($loop->index % 3 == 0)
                    bg-blue-500
                @elseif($loop->index % 3 == 1)
                    bg-orange-500
                @else
                    bg-blue-300
                @endif
            "></div>
            <div class="p-5">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-xl font-semibold text-gray-800 truncate">{{ $set->title }}</h2>
                    <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                        {{ $set->cards_count ?? 0 }} cartes
                    </span>
                </div>
                <p class="text-sm text-gray-500 mb-2">Créé il y a {{ $set->created_at->diffForHumans(null, true) }}</p>
                @if(isset($set->progress))
                <div class="flex items-center mb-4">
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $set->progress }}%"></div>
                    </div>
                    <span class="text-xs text-gray-500 ml-2">{{ $set->progress }}%</span>
                </div>
                @endif
            </div>
            <div class="bg-gray-50 px-5 py-3 flex justify-between border-t">
                <div class="flex space-x-2">
                    <a href="{{ route('flashcards.show', $set) }}" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-play mr-1"></i>Réviser
                    </a>
                    <a href="{{ route('flashcards.edit', $set) }}" class="text-yellow-500 hover:text-yellow-700">
                        <i class="fas fa-edit mr-1"></i>Modifier
                    </a>
                    <form action="{{ route('flashcards.destroy', $set) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce jeu de flashcards?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash mr-1"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $flashcardSets->links() }}
    </div>
    @endif

    <!-- Statistiques -->
    <h2 class="text-xl font-bold text-gray-800 mb-4">Statistiques de révision</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-5 border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-2">Total des cartes</h3>
            <p class="text-3xl font-bold text-blue-500">{{ $stats['total'] ?? 0 }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-5 border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-2">Cartes révisées</h3>
            <p class="text-3xl font-bold text-green-500">{{ $stats['revised'] ?? 0 }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-5 border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-2">Progression globale</h3>
            <div class="flex items-center">
                <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                    <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $stats['progress'] ?? 0 }}%"></div>
                </div>
                <span class="text-sm font-medium text-gray-500">{{ $stats['progress'] ?? 0 }}%</span>
            </div>
        </div>
    </div>
</div>
@endsection