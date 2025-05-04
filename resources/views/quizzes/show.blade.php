@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $quiz->title }}</h1>
        <p class="text-gray-600">Créé le {{ $quiz->created_at->format('d/m/Y à H:i') }}</p>
    </div>

    @if(session('error'))
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('quizzes.submit', $quiz) }}" method="POST">
        @csrf
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-6">
                @foreach($quiz->questions as $index => $question)
                <div class="mb-8 pb-6 border-b border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                    <h3 class="text-xl font-semibold mb-4">Question {{ $index + 1 }}: {{ $question->question_text }}</h3>
                    
                    {{-- Affichage différent selon le type de question --}}
                    @if($question->type == 'choix_multiple')
                        <div class="space-y-3">
                            @php
                                // Récupérer les options depuis incorrect_answers
                                $incorrectAnswers = json_decode($question->incorrect_answers, true) ?? [];
                                
                                // S'assurer que incorrect_answers est un tableau
                                if (!is_array($incorrectAnswers)) {
                                    $incorrectAnswers = [];
                                }
                                
                                // Combiner avec la réponse correcte
                                $optionsArray = array_merge([$question->correct_answer], $incorrectAnswers);
                                
                                // Mélanger les options
                                shuffle($optionsArray);
                            @endphp
                            
                            @foreach($optionsArray as $option)
                            <div class="flex items-center">
                                <input type="radio" name="answers[{{ $question->id }}]" id="q{{ $question->id }}_{{ $loop->index }}" 
                                    value="{{ $option }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                <label for="q{{ $question->id }}_{{ $loop->index }}" class="ml-3 block text-gray-700">
                                    {{ $option }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    
                    @elseif($question->type == 'vrai_faux')
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="radio" name="answers[{{ $question->id }}]" id="q{{ $question->id }}_true" 
                                    value="Vrai" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                <label for="q{{ $question->id }}_true" class="ml-3 block text-gray-700">Vrai</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="answers[{{ $question->id }}]" id="q{{ $question->id }}_false" 
                                    value="Faux" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                <label for="q{{ $question->id }}_false" class="ml-3 block text-gray-700">Faux</label>
                            </div>
                        </div>
                    
                    @elseif($question->type == 'reponse_court')
                        <div class="mt-4">
                            <label for="answer_{{ $question->id }}" class="block text-sm font-medium text-gray-700 mb-2">Votre réponse:</label>
                            <textarea 
                                id="answer_{{ $question->id }}" 
                                name="answers[{{ $question->id }}]" 
                                rows="4" 
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-2"
                                placeholder="Saisissez votre réponse ici..."
                            ></textarea>
                        </div>
                    
                    @else
                        {{-- Type par défaut (si le type n'est pas reconnu) --}}
                        <div class="mt-4">
                            <label for="answer_{{ $question->id }}" class="block text-sm font-medium text-gray-700 mb-2">Votre réponse:</label>
                            <textarea 
                                id="answer_{{ $question->id }}" 
                                name="answers[{{ $question->id }}]" 
                                rows="4" 
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-2"
                                placeholder="Saisissez votre réponse ici..."
                            ></textarea>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
            
            <div class="bg-gray-50 px-6 py-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Valider mes réponses
                </button>
            </div>
        </div>
    </form>

    <div class="mt-6">
        <a href="{{ route('quizzes.index') }}" class="text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-1"></i>Retour à la liste des quiz
        </a>
    </div>
</div>
@endsection