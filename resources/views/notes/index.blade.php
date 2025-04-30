@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Notes</h1>
        <div class="space-x-2">
            <a href="{{ route('notes.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition">
                Importer une notes
            </a>
            <a href="{{ route('notes.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition">
                + Ajouter des Notes
            </a>
        </div>
    </div>

    <!-- Onglets de filtrage -->
    <div class="flex space-x-2 mb-6">
        <button class="px-4 py-2 bg-gray-100 rounded-full text-gray-700 font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 active">
            Toutes
        </button>
        <button class="px-4 py-2 bg-gray-100 rounded-full text-gray-700 font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Récentes
        </button>
        <button class="px-4 py-2 bg-gray-100 rounded-full text-gray-700 font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Par matière
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <!-- Notes récentes -->
    <h2 class="text-xl font-bold text-gray-800 mb-4">Notes récentes</h2>
    @if($notes->isEmpty())
    <div class="bg-gray-100 rounded-lg p-8 text-center mb-8">
        <p class="text-gray-600 text-lg">Vous n'avez pas encore de notes. Commencez par en créer une !</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach($notes->take(3) as $key => $note)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden border border-gray-200">
            <!-- Barre colorée en haut de la carte -->
            <div class="h-2 w-full 
                @if($key % 3 == 0)
                    bg-blue-500
                @elseif($key % 3 == 1)
                    bg-orange-500
                @else
                    bg-blue-300
                @endif
            "></div>
            <div class="p-5">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-xl font-semibold text-gray-800 truncate">{{ $note->title }}</h2>
                    <span class="px-2 py-1 rounded-full text-xs {{ $note->statut == 'publiee' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($note->statut) }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mb-2">{{ $note->matiere }} • Modifié il y a {{ $note->updated_at->diffForHumans(null, true) }}</p>
                <p class="text-gray-600 mb-4 h-12 overflow-hidden">{{ Str::limit(strip_tags($note->content), 100) }}</p>
            </div>
            <div class="bg-gray-50 px-5 py-3 flex justify-between border-t">
                <div class="flex space-x-2">
                    <a href="{{ route('notes.show', $note) }}" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-eye mr-1"></i>Voir
                    </a>
                    <a href="{{ route('notes.edit', $note) }}" class="text-yellow-500 hover:text-yellow-700">
                        <i class="fas fa-edit mr-1"></i>Modifier
                    </a>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash mr-1"></i>Supprimer
                        </button>
                    </form>
                </div>
                <a href="{{ route('quizzes.create') }}" class="text-blue-500 hover:text-blue-700">
                    Générer Quiz
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Par matière -->
    <h2 class="text-xl font-bold text-gray-800 mb-4">Par matière</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-blue-50 p-4 rounded-lg">
            <div class="flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full mb-2">B</div>
            <h3 class="font-medium">{{ $note->matiere }}</h3>
            <p class="text-sm text-gray-500">{{ $notes->where('matiere', $note->matiere)->count() }} notes</p>
            <p class="text-xs text-gray-400 mt-1">Dernière modif: Aujourd'hui</p>
        </div>
        
        <div class="bg-orange-50 p-4 rounded-lg">
            <div class="flex items-center justify-center w-8 h-8 bg-orange-500 text-white rounded-full mb-2">M</div>
            <h3 class="font-medium">{{ $note->matiere }}</h3>
            <p class="text-sm text-gray-500">{{ $notes->where('matiere', $note->matiere)->count() }} notes</p>
            <p class="text-xs text-gray-400 mt-1">Dernière modif: Hier</p>
        </div>
        
        <div class="bg-blue-50 p-4 rounded-lg">
            <div class="flex items-center justify-center w-8 h-8 bg-blue-300 text-white rounded-full mb-2">A</div>
            <h3 class="font-medium">{{ $note->matiere }}</h3>
            <p class="text-sm text-gray-500">{{ $notes->where('matiere', $note->matiere)->count() }} notes</p>
            <p class="text-xs text-gray-400 mt-1">Dernière modif: Il y a 3j</p>
        </div>
        
        <div class="bg-green-50 p-4 rounded-lg">
            <div class="flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-full mb-2">C</div>
            <h3 class="font-medium">{{ $note->matiere }}</h3>
            <p class="text-sm text-gray-500">{{ $notes->where('matiere', $note->matiere)->count() }} notes</p>
            <p class="text-xs text-gray-400 mt-1">Dernière modif: Il y a 5j</p>
        </div>
        
        <div class="bg-purple-50 p-4 rounded-lg">
            <div class="flex items-center justify-center w-8 h-8 bg-purple-500 text-white rounded-full mb-2">P</div>
            <h3 class="font-medium">{{ $note->matiere }}</h3>
            <p class="text-sm text-gray-500">{{ $notes->where('matiere', $note->matiere)->count() }} notes</p>
            <p class="text-xs text-gray-400 mt-1">Dernière modif: Il y a 4j</p>
        </div>
    </div>

    <!-- Recommandé pour vous -->
    <h2 class="text-xl font-bold text-gray-800 mb-4">Recommandé pour vous <span class="text-xs font-normal text-gray-500">Powered by AI</span></h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
            <h3 class="font-medium mb-1">Réviser les bases de la biologie cellulaire</h3>
            <p class="text-sm text-gray-500 mb-3">Quiz hebdomadaire prévu dans 2 jours</p>
            <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-1 rounded text-sm">Réviser</button>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
            <h3 class="font-medium mb-1">Compléter vos notes sur les équations diff.</h3>
            <p class="text-sm text-gray-500 mb-3">Des concepts importants manquent à votre révision</p>
            <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-1 rounded text-sm">Éditer</button>
        </div>
    </div>

    <!-- Prise de note rapide -->
    <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200 flex justify-between items-center">
        <input type="text" placeholder="Prise de note rapide..." class="w-full focus:outline-none text-gray-700">
        <button class="text-blue-500 hover:text-blue-700 ml-2 text-xl">+</button>
    </div>
</div>
@endsection