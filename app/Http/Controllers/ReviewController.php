<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flashcard;
use App\Models\Card;
use App\Models\CardUserReview;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Affiche la page de révision pour un jeu de flashcards spécifique
     */
    public function reviewDeck(Flashcard $flashcard)
    {
        // Récupérer toutes les cartes du jeu de flashcards
        $cards = $flashcard->cards()->get();
        
        if ($cards->isEmpty()) {
            return redirect()->route('flashcards.index')
                ->with('error', 'Ce jeu de flashcards ne contient aucune carte.');
        }
        
        return view('reviews.deck', [
            'flashcard' => $flashcard,
            'cards' => $cards,
            'currentCard' => $cards->first()
        ]);
    }

    /**
     * Traite la révision d'une carte par l'utilisateur
     */
    public function processReview(Request $request, Card $card)
    {
        $user = Auth::user();
        
        // Valider la requête
        $validated = $request->validate([
            'quality_score' => ['required', 'integer', 'min:0', 'max:5'],
        ]);
        
        // Récupérer ou créer l'enregistrement de révision
        $review = CardUserReview::firstOrCreate(
            ['user_id' => $user->id, 'card_id' => $card->id],
            [
                'ease_factor' => 2.5,
                'interval' => 0,
                'repetitions' => 0,
                'next_review_at' => now(),
            ]
        );
        
        // Algorithme SRS simple
        $qualityScore = $validated['quality_score'];
        $easeFactor = $review->ease_factor;
        $interval = $review->interval;
        $repetitions = $review->repetitions;
        
        // Si la réponse était incorrecte
        if ($qualityScore < 3) {
            $repetitions = 0;
            $interval = 1;
        } else {
            // La réponse était correcte
            $repetitions++;
            
            // Calculer le nouvel intervalle
            if ($repetitions == 1) {
                $interval = 1;
            } elseif ($repetitions == 2) {
                $interval = 6;
            } else {
                $interval = round($interval * $easeFactor);
            }
        }
        
        // Ajuster le facteur de facilité
        $easeFactor = max(1.3, $easeFactor + (0.1 - (5 - $qualityScore) * (0.08 + (5 - $qualityScore) * 0.02)));
        
        // Mettre à jour l'enregistrement de révision
        $review->update([
            'ease_factor' => $easeFactor,
            'interval' => $interval,
            'repetitions' => $repetitions,
            'next_review_at' => now()->addDays($interval),
        ]);
        
        // Rediriger vers la page de révision du jeu
        return redirect()->back()->with('status', 'Réponse enregistrée !');
    }
}