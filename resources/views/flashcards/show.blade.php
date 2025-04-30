@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $flashcard->title }}</h1>
        <div class="space-x-2">
            <a href="{{ route('flashcards.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition">
                Retour
            </a>
            <a href="{{ route('flashcards.edit', $flashcard) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg transition">
                Modifier
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        @if($flashcard->description)
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Description</h2>
            <p class="text-gray-600">{{ $flashcard->description }}</p>
        </div>
        @endif

        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Mode Révision</h2>
            
            <div id="flashcard-container" class="relative">
                <div id="card" class="w-full h-64 bg-blue-50 rounded-xl shadow-md cursor-pointer transition-transform duration-700 transform-style-3d">
                    <div id="front" class="absolute inset-0 backface-hidden flex items-center justify-center p-6 text-center">
                        <p class="text-xl font-medium text-gray-800">Cliquez sur la carte pour voir la réponse</p>
                    </div>
                    <div id="back" class="absolute inset-0 backface-hidden flex items-center justify-center p-6 text-center rotate-y-180">
                        <p class="text-xl font-medium text-gray-800">La réponse apparaîtra ici</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between mt-6">
                <button id="prev-btn" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Précédent
                </button>
                <div class="text-gray-600">
                    Carte <span id="current-card">0</span> / <span id="total-cards">0</span>
                </div>
                <button id="next-btn" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Suivant
                </button>
            </div>
        </div>
        
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Toutes les cartes</h2>
            
            <div class="space-y-4">
                @if(isset($flashcard->cards) && count($flashcard->cards) > 0)
                    @foreach($flashcard->cards as $index => $card)
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                            <h3 class="font-medium text-gray-700">Carte {{ $index + 1 }}</h3>
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
                @else
                    <div class="text-center py-8 text-gray-500">
                        Aucune carte n'a été ajoutée à ce jeu de flashcards.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .transform-style-3d {
        transform-style: preserve-3d;
    }
    .backface-hidden {
        backface-visibility: hidden;
    }
    .rotate-y-180 {
        transform: rotateY(180deg);
    }
    .card-flipped {
        transform: rotateY(180deg);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const card = document.getElementById('card');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const currentCardEl = document.getElementById('current-card');
        const totalCardsEl = document.getElementById('total-cards');
        const frontEl = document.getElementById('front');
        const backEl = document.getElementById('back');
        
        // Exemple de données de cartes (à remplacer par les vraies données)
        const cards = @json($flashcard->cards ?? []);
        let currentIndex = 0;
        
        // Initialiser l'affichage
        updateCardDisplay();
        
        // Événement de clic sur la carte pour la retourner
        card.addEventListener('click', function() {
            card.classList.toggle('card-flipped');
        });
        
        // Bouton précédent
        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateCardDisplay();
                card.classList.remove('card-flipped');
            }
        });
        
        // Bouton suivant
        nextBtn.addEventListener('click', function() {
            if (currentIndex < cards.length - 1) {
                currentIndex++;
                updateCardDisplay();
                card.classList.remove('card-flipped');
            }
        });
        
        // Mettre à jour l'affichage de la carte
        function updateCardDisplay() {
            if (cards.length === 0) {
                frontEl.innerHTML = '<p class="text-xl font-medium text-gray-800">Aucune carte disponible</p>';
                backEl.innerHTML = '<p class="text-xl font-medium text-gray-800">Ajoutez des cartes pour commencer</p>';
                prevBtn.disabled = true;
                nextBtn.disabled = true;
                currentCardEl.textContent = '0';
                totalCardsEl.textContent = '0';
                return;
            }
            
            const currentCard = cards[currentIndex];
            frontEl.innerHTML = `<p class="text-xl font-medium text-gray-800">${currentCard.question}</p>`;
            backEl.innerHTML = `<p class="text-xl font-medium text-gray-800">${currentCard.answer}</p>`;
            
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex === cards.length - 1;
            
            currentCardEl.textContent = (currentIndex + 1).toString();
            totalCardsEl.textContent = cards.length.toString();
        }
    });
</script>
@endsection