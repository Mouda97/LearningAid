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

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    @if(isset($error))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
        <p>{{ $error }}</p>
    </div>
    @endif

    <!-- Liste des notes -->
    @if(!isset($notes) || $notes->isEmpty())
    <div class="bg-gray-100 rounded-lg p-8 text-center mb-8">
        <p class="text-gray-600 text-lg">Vous n'avez pas encore de notes. Commencez par en créer une !</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach($notes as $note)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-200">
            <!-- Bande colorée en haut de la carte -->
            @php
                // Alterner entre bleu et orange pour chaque carte
                $color = $loop->iteration % 2 == 0 ? 'orange' : 'blue';
            @endphp
            <div class="h-2 w-full bg-{{ $color }}-500"></div>
            
            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-semibold text-lg text-gray-800">{{ $note->title }}</h3>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $note->statut }}</span>
                </div>
                <p class="text-gray-600 mb-4 line-clamp-3 text-sm">{{ Str::limit($note->content, 150) }}</p>
                <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                    <span class="text-sm text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ $note->matiere }}
                    </span>
                    <div class="flex space-x-2">
                        <a href="{{ route('notes.edit', $note) }}" class="text-gray-500 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <a href="{{ route('notes.show', $note) }}" class="text-gray-500 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-400">
                    Dernière modification: {{ $note->updated_at->diffForHumans() }}
                </div>
                
                <!-- Boutons pour générer des quiz et des flashcards -->
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('quizzes.create', ['note_id' => $note->id]) }}" class="flex items-center justify-center px-3 py-1.5 bg-purple-100 text-purple-700 rounded-md text-xs font-medium hover:bg-purple-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Générer un quiz
                    </a>
                    <a href="{{ route('flashcards.create', ['note_id' => $note->id]) }}" class="flex items-center justify-center px-3 py-1.5 bg-green-100 text-green-700 rounded-md text-xs font-medium hover:bg-green-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Créer des flashcards
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination et lien "Voir plus" -->
    <div class="mt-6 flex flex-col items-center">
        @if(method_exists($notes, 'hasPages') && $notes->hasPages())
            <div class="mb-4">
                {{ $notes->links() }}
            </div>
            
            @if($notes->hasMorePages())
                <a href="{{ route('notes.index', ['page' => $notes->currentPage() + 1]) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition">
                    Voir plus
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
            @endif
        @endif
    </div>
    @endif
    <!-- Par matière -->
    <h2 class="text-xl font-bold text-gray-800 mb-4">Par matière</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8">
        @if(isset($matieres) && count($matieres) > 0)
            @foreach($matieres as $matiere)
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full mb-2">{{ substr($matiere->nom, 0, 1) }}</div>
                <h3 class="font-medium">{{ $matiere->nom }}</h3>
                <p class="text-sm text-gray-500">{{ $matiere->notes_count }} notes</p>
                <p class="text-xs text-gray-400 mt-1">Dernière modif: {{ $matiere->derniere_modif }}</p>
            </div>
            @endforeach
        @else
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full mb-2">B</div>
                <h3 class="font-medium">Biologie</h3>
                <p class="text-sm text-gray-500">5 notes</p>
                <p class="text-xs text-gray-400 mt-1">Dernière modif: Aujourd'hui</p>
            </div>
            
            <div class="bg-orange-50 p-4 rounded-lg">
                <div class="flex items-center justify-center w-8 h-8 bg-orange-500 text-white rounded-full mb-2">M</div>
                <h3 class="font-medium">Mathématiques</h3>
                <p class="text-sm text-gray-500">8 notes</p>
                <p class="text-xs text-gray-400 mt-1">Dernière modif: Hier</p>
            </div>
            
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-300 text-white rounded-full mb-2">A</div>
                <h3 class="font-medium">Anglais</h3>
                <p class="text-sm text-gray-500">3 notes</p>
                <p class="text-xs text-gray-400 mt-1">Dernière modif: Il y a 3j</p>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-full mb-2">C</div>
                <h3 class="font-medium">Chimie</h3>
                <p class="text-sm text-gray-500">6 notes</p>
                <p class="text-xs text-gray-400 mt-1">Dernière modif: Il y a 5j</p>
            </div>
            
            <div class="bg-purple-50 p-4 rounded-lg">
                <div class="flex items-center justify-center w-8 h-8 bg-purple-500 text-white rounded-full mb-2">P</div>
                <h3 class="font-medium">Physique</h3>
                <p class="text-sm text-gray-500">4 notes</p>
                <p class="text-xs text-gray-400 mt-1">Dernière modif: Il y a 4j</p>
            </div>
        @endif
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