@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Quiz</h1>
        <a href="{{ route('quizzes.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition">
            + Créer un Quiz
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <!-- Filtres -->
    <div class="flex space-x-2 mb-6">
        <button class="px-4 py-2 bg-gray-100 rounded-full text-gray-700 font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 active">
            Tous
        </button>
        <button class="px-4 py-2 bg-gray-100 rounded-full text-gray-700 font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
            À faire
        </button>
        <button class="px-4 py-2 bg-gray-100 rounded-full text-gray-700 font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Complétés
        </button>
    </div>

    <!-- Liste des quiz -->
    @if($quizzes->isEmpty())
    <div class="bg-gray-100 rounded-lg p-8 text-center mb-8">
        <p class="text-gray-600 text-lg">Vous n'avez pas encore de quiz. Commencez par en créer un !</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach($quizzes as $quiz)
        <div class="rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
            <div class="p-4 text-white
                @if($loop->index % 3 == 0)
                    bg-blue-500
                @elseif($loop->index % 3 == 1)
                    bg-blue-400
                @else
                    bg-blue-500
                @endif
            ">
                <h2 class="text-xl font-semibold truncate">{{ $quiz->title }}</h2>
            </div>
            <div class="p-4 bg-white">
                <p class="text-sm text-gray-600">{{ $quiz->description ?? 'Chapitre: ' . $quiz->chapter }}</p>
                <p class="text-sm text-gray-600 mt-2">{{ $quiz->questions_count ?? 0 }} questions • {{ $quiz->time_limit ?? 15 }} minutes</p>
                @if(isset($quiz->last_score))
                <p class="text-sm text-blue-600 mt-2">Score précédent: {{ $quiz->last_score }}%</p>
                @else
                <p class="text-sm text-orange-500 mt-2">Nouveau</p>
                @endif
            </div>
            <div class="bg-white px-5 py-3 flex justify-between border-t">
                <div class="flex space-x-2">
                    <a href="{{ route('quizzes.show', $quiz) }}" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-play mr-1"></i>Commencer
                    </a>
                    <a href="{{ route('quizzes.edit', $quiz) }}" class="text-yellow-500 hover:text-yellow-700">
                        <i class="fas fa-edit mr-1"></i>Modifier
                    </a>
                    <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce quiz?');">
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
        {{ $quizzes->links() }}
    </div>
    @endif

    <!-- Quiz suggérés par l'IA -->
    <h2 class="text-xl font-bold text-gray-800 mb-4">Quiz suggérés par l'IA</h2>
    <p class="text-sm text-gray-600 mb-4">Basés sur vos notes récentes</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
            <div class="p-4 text-white bg-orange-500">
                <h3 class="text-lg font-semibold">Quiz IA: Biologie</h3>
            </div>
            <div class="p-4 bg-white">
                <p class="text-sm text-gray-600">Génétique moléculaire</p>
                <p class="text-sm text-gray-600 mt-2">10 questions • 15 min</p>
                <p class="text-xs text-orange-500 mt-2">Généré aujourd'hui</p>
            </div>
        </div>
        <div class="rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
            <div class="p-4 text-white bg-orange-500">
                <h3 class="text-lg font-semibold">Quiz IA: Économie</h3>
            </div>
            <div class="p-4 bg-white">
                <p class="text-sm text-gray-600">Microéconomie</p>
                <p class="text-sm text-gray-600 mt-2">12 questions • 15 min</p>
                <p class="text-xs text-gray-500 mt-2">Généré hier</p>
            </div>
        </div>
    </div>

    <!-- Quiz partagés -->
    <h2 class="text-xl font-bold text-gray-800 mb-4">Quiz partagés avec moi</h2>
    <p class="text-sm text-gray-600 mb-4">Par vos groupes d'étude</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
            <div class="p-4 text-white bg-blue-500">
                <h3 class="text-lg font-semibold">Quiz: Informatique</h3>
            </div>
            <div class="p-4 bg-white">
                <p class="text-sm text-gray-600">Structures de données</p>
                <p class="text-sm text-gray-600 mt-2">15 questions • 20 min</p>
                <p class="text-xs text-gray-500 mt-2">Partagé par: Marie D.</p>
            </div>
        </div>
        <div class="rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
            <div class="p-4 text-white bg-blue-500">
                <h3 class="text-lg font-semibold">Quiz: Chimie</h3>
            </div>
            <div class="p-4 bg-white">
                <p class="text-sm text-gray-600">Thermodynamique</p>
                <p class="text-sm text-gray-600 mt-2">10 questions • 15 min</p>
                <p class="text-xs text-gray-500 mt-2">Partagé par: Thomas L.</p>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <h2 class="text-xl font-bold text-gray-800 mb-4">Statistiques de vos quiz</h2>
    <div class="bg-white rounded-lg shadow-md p-5 border border-gray-200 mb-8">
        <div class="h-40 w-full">
            <!-- Ici vous pourriez intégrer un graphique réel avec Chart.js ou une autre bibliothèque -->
            <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                <p class="text-gray-400">Graphique de progression des quiz</p>
            </div>
        </div>
    </div>
</div>
@endsection