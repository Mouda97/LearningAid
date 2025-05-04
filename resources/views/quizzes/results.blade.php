@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Résultats du Quiz: {{ $quiz->title }}</h1>
        <p class="text-gray-600">Complété le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="p-6">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold">Votre score</h2>
                <p class="text-4xl font-bold mt-2 {{ $score/$quiz->questions->count() >= 0.7 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $score }}/{{ $quiz->questions->count() }}
                </p>
                <p class="mt-2 text-gray-600">
                    {{ round(($score/$quiz->questions->count())*100) }}% de réponses correctes
                </p>
            </div>

            <div class="mt-8">
                <h3 class="text-xl font-semibold mb-4">Détail des réponses</h3>
                
                @foreach($quiz->questions as $index => $question)
                <div class="mb-8 pb-6 border-b border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            @if($results[$question->id]['correct'])
                                <span class="flex items-center justify-center w-8 h-8 bg-green-100 text-green-800 rounded-full">
                                    <i class="fas fa-check"></i>
                                </span>
                            @else
                                <span class="flex items-center justify-center w-8 h-8 bg-red-100 text-red-800 rounded-full">
                                    <i class="fas fa-times"></i>
                                </span>
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <h4 class="text-lg font-medium">Question {{ $index + 1 }}: {{ $question->question_text }}</h4>
                            
                            <div class="mt-3">
                                <p class="font-medium">Votre réponse:</p>
                                <p class="{{ $results[$question->id]['correct'] ? 'text-green-600' : 'text-red-600' }} ml-4">
                                    {{ $results[$question->id]['user_answer'] }}
                                </p>
                            </div>
                            
                            @if(!$results[$question->id]['correct'])
                            <div class="mt-2">
                                <p class="font-medium">Réponse correcte:</p>
                                <p class="text-green-600 ml-4">{{ $question->correct_answer }}</p>
                            </div>
                            @endif
                            
                            @php
                                $options = json_decode($question->incorrect_answers, true) ?? [];
                                $allOptions = array_merge([$question->correct_answer], $options);
                            @endphp
                            
                            <div class="mt-3">
                                <p class="font-medium">Toutes les options:</p>
                                <ul class="ml-4 mt-1 list-disc list-inside">
                                    @foreach($allOptions as $option)
                                        <li class="{{ $option === $question->correct_answer ? 'text-green-600 font-medium' : '' }}">
                                            {{ $option }}
                                            @if($option === $question->correct_answer)
                                                <span class="text-green-600">(Correcte)</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex space-x-4">
        <a href="{{ route('quizzes.show', $quiz) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Refaire ce quiz
        </a>
        <a href="{{ route('quizzes.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            Retour à la liste des quiz
        </a>
    </div>
</div>
@endsection