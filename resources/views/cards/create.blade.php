@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ajouter une carte</h1>
        <a href="{{ route('flashcards.edit', $flashcard) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition">
            Retour
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('cards.store', $flashcard) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="front" class="block text-gray-700 font-medium mb-2">Question</label>
                <textarea name="front" id="front" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('front') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="back" class="block text-gray-700 font-medium mb-2">Réponse</label>
                <textarea name="back" id="back" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('back') }}</textarea>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-lg transition">
                    Ajouter la carte
                </button>
            </div>
        </form>
    </div>
</div>
@endsection