@extends('etudiant.baseE')
@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-800">{{ $quiz->title }}</h1>
                <span class="px-3 py-1 rounded-full text-sm font-semibold 
                    {{ $quiz->statut == 'publié' ? 'bg-green-100 text-green-800' : 
                      ($quiz->statut == 'brouillon' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ ucfirst($quiz->statut) }}
                </span>
            </div>
            
            <p class="text-gray-600 mb-4">{{ $quiz->description }}</p>
            
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 p-3 rounded">
                    <p class="text-sm text-gray-500">Nombre de questions</p>
                    <p class="text-lg font-semibold">{{ $quiz->nombre_questions }}</p>
                </div>
                <div class="bg-gray-50 p-3 rounded">
                    <p class="text-sm text-gray-500">Temps limite</p>
                    <p class="text-lg font-semibold">{{ $quiz->temps_limite ? $quiz->temps_limite . ' minutes' : 'Illimité' }}</p>
                </div>
            </div>
            
            <div class="flex space-x-2 mb-8">
                <a href="{{ route('quizzes.edit', $quiz) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Modifier</a>
                <a href="{{ route('quizzes.questions.create', $quiz) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Ajouter une question</a>
                <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce quiz?')">Supprimer</button>
                </form>
            </div>
            
            <h2 class="text-xl font-semibold mb-4">Questions</h2>
            
            @if($quiz->questions->count() > 0)
                <div class="space-y-4">
                    @foreach($quiz->questions as $index => $question)
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between">
                            <h3 class="font-medium">Question {{ $index + 1 }}</h3>
                            <div class="flex space-x-2">
                                <a href="{{ route('quizzes.questions.edit', [$quiz, $question]) }}" class="text-blue-500 hover:text-blue-700">Modifier</a>
                                <form action="{{ route('quizzes.questions.destroy', [$quiz, $question]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question?')">Supprimer</button>
                                </form>
                            </div>
                        </div>
                        <p class="mt-2">{{ $question->question_text }}</p>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Réponse correcte: {{ $question->correct_answer }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 p-4 rounded text-center">
                    <p class="text-gray-500">Aucune question n'a encore été ajoutée à ce quiz.</p>
                    <a href="{{ route('quizzes.questions.create', $quiz) }}" class="mt-2 inline-block text-blue-500 hover:text-blue-700">Ajouter une question</a>
                </div>
            @endif
            
            <div class="mt-6">
                <a href="{{ route('quizzes.index') }}" class="text-blue-500 hover:text-blue-700">Retour à la liste des quiz</a>
            </div>
        </div>
    </div>
</div>
@endsection