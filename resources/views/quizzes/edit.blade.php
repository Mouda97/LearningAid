@extends('etudiant.baseE')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Modifier le Quiz</h1>

    <div class="bg-white shadow rounded-md p-4 mb-4">
        <form action="{{ route('quizzes.update', $quiz) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre</label>
                <input type="text" id="title" name="title" value="{{ old('title', $quiz->title) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $quiz->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="note_id" class="block text-gray-700 text-sm font-bold mb-2">Notes (Optionnel)</label>
                <select id="note_id" name="note_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Aucune</option>
                    @foreach (\App\Models\Note::all() as $note)
                        <option value="{{ $note->id }}" {{ old('note_id', $quiz->note_id) == $note->id ? 'selected' : '' }}>
                            {{ $note->nom }}</option>
                    @endforeach
                </select>
                @error('note_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nombre_questions" class="block text-gray-700 text-sm font-bold mb-2">Nombre de Questions</label>
                <input type="number" id="nombre_questions" name="nombre_questions" value="{{ old('nombre_questions', $quiz->nombre_questions) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                @error('nombre_questions')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="temps_limite" class="block text-gray-700 text-sm font-bold mb-2">Temps Limite (minutes)</label>
                <input type="number" id="temps_limite" name="temps_limite" value="{{ old('temps_limite', $quiz->temps_limite) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('temps_limite')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="statut" class="block text-gray-700 text-sm font-bold mb-2">Statut</label>
                <select id="statut" name="statut"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                    <option value="brouillon" {{ old('statut', $quiz->statut) == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                    <option value="publié" {{ old('statut', $quiz->statut) == 'publié' ? 'selected' : '' }}>Publié</option>
                    <option value="archivé" {{ old('statut', $quiz->statut) == 'archivé' ? 'selected' : '' }}>Archivé</option>
                </select>
                @error('statut')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Mettre à jour
                </button>
                <a href="{{ route('quizzes.index') }}"
                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection