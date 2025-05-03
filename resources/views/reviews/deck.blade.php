@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Révision: {{ $flashcard->title }}</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="mb-4">
            <p class="text-gray-600 mb-2">Description</p>
            <p>{{ $flashcard->description }}</p>
        </div>
        
        <div class="mb-4">
            <p class="text-gray-600 mb-2">Mode Révision Espacée</p>
            <div class="bg-blue-50 p-6 rounded-lg">
                <div id="card-container">
                    @if($cards->count() > 0)
                        <div id="front" class="mb-4">
                            <h3 class="font-bold mb-2">Question:</h3>
                            <p id="front-text">{{ $currentCard->front }}</p>
                        </div>
                        
                        <div id="back" class="mb-4 hidden">
                            <h3 class="font-bold mb-2">Réponse:</h3>
                            <p id="back-text">{{ $currentCard->back }}</p>
                        </div>
                        
                        <button id="showAnswer" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Afficher la réponse
                        </button>
                        
                        <div id="ratingButtons" class="mt-4 hidden">
                            <form id="reviewForm" action="{{ route('reviews.process', $currentCard->id) }}" method="POST">
                                @csrf
                                <div class="flex space-x-2">
                                    <button type="submit" name="quality_score" value="0" class="bg-red-500 text-white px-4 py-2 rounded">
                                        Difficile
                                    </button>
                                    <button type="submit" name="quality_score" value="3" class="bg-yellow-500 text-white px-4 py-2 rounded">
                                        Moyen
                                    </button>
                                    <button type="submit" name="quality_score" value="5" class="bg-green-500 text-white px-4 py-2 rounded">
                                        Facile
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <p>Aucune carte disponible pour ce jeu de flashcards.</p>
                    @endif
                </div>
            </div>
        </div>
        
        @if($cards->count() > 0)
        <div class="flex justify-between items-center">
            <button id="prevCard" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Précédent</button>
            <span id="cardCounter">Carte 1 / {{ $cards->count() }}</span>
            <button id="nextCard" class="bg-blue-500 text-white px-4 py-2 rounded">Suivant</button>
        </div>
        @endif
    </div>
</div>

<script>
// Stocker toutes les cartes dans une variable JavaScript
const cards = @json($cards);
let currentCardIndex = 0;

// Fonction pour afficher une carte spécifique
function showCard(index) {
    if (index >= 0 && index < cards.length) {
        currentCardIndex = index;
        
        // Mettre à jour la question et la réponse
        document.getElementById('front-text').textContent = cards[index].front;
        document.getElementById('back-text').textContent = cards[index].back;
        
        // Mettre à jour le compteur de cartes
        document.getElementById('cardCounter').textContent = `Carte ${index + 1} / ${cards.length}`;
        
        // Réinitialiser l'interface (cacher la réponse, etc.)
        document.getElementById('back').classList.add('hidden');
        document.getElementById('ratingButtons').classList.add('hidden');
        document.getElementById('showAnswer').classList.remove('hidden');
        
        // Mettre à jour le formulaire pour pointer vers la bonne carte
        const form = document.getElementById('reviewForm');
        form.action = "{{ url('/review/process') }}/" + cards[index].id;
    }
}

// Gestionnaire d'événements pour le bouton "Afficher la réponse"
document.getElementById('showAnswer').addEventListener('click', function() {
    document.getElementById('back').classList.remove('hidden');
    document.getElementById('ratingButtons').classList.remove('hidden');
    this.classList.add('hidden');
});

// Gestionnaires d'événements pour les boutons de navigation
document.getElementById('prevCard').addEventListener('click', function() {
    if (currentCardIndex > 0) {
        showCard(currentCardIndex - 1);
    }
});

document.getElementById('nextCard').addEventListener('click', function() {
    if (currentCardIndex < cards.length - 1) {
        showCard(currentCardIndex + 1);
    }
});
</script>
@endsection