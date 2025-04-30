@extends('etudiant.baseE')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Ajouter une question au quiz: {{ $quiz->title }}</h1>

    <div class="bg-white shadow rounded-md p-4 mb-4">
        <form action="{{ route('quizzes.questions.store', $quiz) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="question_text" class="block text-gray-700 text-sm font-bold mb-2">Question</label>
                <textarea id="question_text" name="question_text" rows="3"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>{{ old('question_text') }}</textarea>
                @error('question_text')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type de question</label>
                <select id="type" name="type"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                    <option value="choix_multiple" {{ old('type') == 'choix_multiple' ? 'selected' : '' }}>Choix multiple</option>
                    <option value="vrai_faux" {{ old('type') == 'vrai_faux' ? 'selected' : '' }}>Vrai/Faux</option>
                    <option value="reponse_courte" {{ old('type') == 'reponse_courte' ? 'selected' : '' }}>Réponse courte</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="correct_answer" class="block text-gray-700 text-sm font-bold mb-2">Réponse correcte</label>
                <input type="text" id="correct_answer" name="correct_answer" value="{{ old('correct_answer') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                @error('correct_answer')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4" id="incorrect_answers_container">
                <label class="block text-gray-700 text-sm font-bold mb-2">Réponses incorrectes</label>
                <div class="space-y-2">
                    <div>
                        <input type="text" name="incorrect_answers[]" value="{{ old('incorrect_answers.0') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <input type="text" name="incorrect_answers[]" value="{{ old('incorrect_answers.1') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <input type="text" name="incorrect_answers[]" value="{{ old('incorrect_answers.2') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
                @error('incorrect_answers')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Ajouter la question
                </button>
                <a href="{{ route('quizzes.show', $quiz) }}"
                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection