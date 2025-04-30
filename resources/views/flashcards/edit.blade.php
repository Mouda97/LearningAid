@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier le jeu de Flashcards</h1>
        <a href="{{ route('flashcards.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition">
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
        <form action="{{ route('flashcards.update', $flashcard) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Titre du jeu</label>
                <input type="text" name="title" id="title" value="{{ old('title', $flashcard->title) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description (optionnel)</label>
                <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $flashcard->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="note_id" class="block text-gray-700 font-medium mb-2">Associer à une note (optionnel)</label>
                <select name="note_id" id="note_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Aucune note</option>
                    @foreach(Auth::user()->notes as $note)
                        <option value="{{ $note->id }}" {{ (old('note_id', $flashcard->note_id) == $note->id) ? 'selected' : '' }}>{{ $note->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-lg transition">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Cartes</h2>
            <a href="{{ route('cards.create', $flashcard) }}" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition">
                + Ajouter une carte
            </a>
        </div>

        @if(isset($flashcard->cards) && count($flashcard->cards) > 0)
            <div class="space-y-4">
                @foreach($flashcard->cards as $card)
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-medium text-gray-700">Carte {{ $loop->iteration }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('cards.edit', [$flashcard, $card]) }}" class="text-yellow-500 hover:text-yellow-700">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('cards.destroy', [$flashcard, $card]) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette carte?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Question</h4>
                            <p class="text-gray-800">{{ $card->question }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Réponse</h4>
                            <p class="text-gray-800">{{ $card->answer }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                Aucune carte n'a été ajoutée à ce jeu de flashcards.
            </div>
        @endif
    </div>
</div>
@endsection