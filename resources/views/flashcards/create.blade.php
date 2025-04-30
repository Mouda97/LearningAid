@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Créer un jeu de Flashcards</h1>
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
        <form action="{{ route('flashcards.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Titre du jeu</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description (optionnel)</label>
                <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="note_id" class="block text-gray-700 font-medium mb-2">Associer à une note (optionnel)</label>
                <select name="note_id" id="note_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Aucune note</option>
                    @foreach(Auth::user()->notes as $note)
                        <option value="{{ $note->id }}" {{ old('note_id') == $note->id ? 'selected' : '' }}>{{ $note->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <h2 class="text-xl font-semibold mb-4">Ajouter des cartes</h2>
                
                <div id="cards-container">
                    <div class="card-item mb-4 p-4 border border-gray-200 rounded-lg">
                        <div class="mb-3">
                            <label class="block text-gray-700 font-medium mb-2">Question</label>
                            <textarea name="cards[0][question]" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Réponse</label>
                            <textarea name="cards[0][answer]" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        </div>
                    </div>
                </div>
                
                <button type="button" id="add-card" class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition">
                    + Ajouter une carte
                </button>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-lg transition">
                    Créer le jeu de flashcards
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cardCount = 1;
        const container = document.getElementById('cards-container');
        const addButton = document.getElementById('add-card');
        
        addButton.addEventListener('click', function() {
            const newCard = document.createElement('div');
            newCard.className = 'card-item mb-4 p-4 border border-gray-200 rounded-lg';
            newCard.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-medium">Carte ${cardCount + 1}</h3>
                    <button type="button" class="remove-card text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700 font-medium mb-2">Question</label>
                    <textarea name="cards[${cardCount}][question]" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Réponse</label>
                    <textarea name="cards[${cardCount}][answer]" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>
            `;
            
            container.appendChild(newCard);
            cardCount++;
            
            // Ajouter l'écouteur d'événement pour supprimer la carte
            const removeButton = newCard.querySelector('.remove-card');
            removeButton.addEventListener('click', function() {
                container.removeChild(newCard);
            });
        });
    });
</script>
@endsection