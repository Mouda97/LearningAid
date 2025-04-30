<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Flashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    /**
     * Show the form for creating a new card.
     */
    public function create(Flashcard $flashcard)
    {
        // Check if the user owns this flashcard
        if ($flashcard->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        return view('cards.create', compact('flashcard'));
    }

    /**
     * Store a newly created card in storage.
     */
    public function store(Request $request, Flashcard $flashcard)
    {
        // Check if the user owns this flashcard
        if ($flashcard->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $data = $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
        ]);
        
        // Ajouter l'ID de l'utilisateur connecté
        $data['user_id'] = Auth::id();
        
        // Ajouter l'ID de la note si le flashcard est associé à une note
        if ($flashcard->note_id) {
            $data['note_id'] = $flashcard->note_id;
        } else {
            // Si le flashcard n'a pas de note_id, on doit s'assurer que note_id est null
            $data['note_id'] = null;
        }
        
        // Créer la carte avec les données validées
        $flashcard->cards()->create($data);
        
        return redirect()->route('flashcards.edit', $flashcard)
            ->with('success', 'Carte ajoutée avec succès !');
    }

    /**
     * Show the form for editing the specified card.
     */
    public function edit(Flashcard $flashcard, Card $card)
    {
        // Check if the user owns this flashcard
        if ($flashcard->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        return view('cards.edit', compact('flashcard', 'card'));
    }

    /**
     * Update the specified card in storage.
     */
    public function update(Request $request, Flashcard $flashcard, Card $card)
    {
        // Check if the user owns this flashcard
        if ($flashcard->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $data = $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
        ]);
        
        $card->update($data);
        
        return redirect()->route('flashcards.edit', $flashcard)
            ->with('success', 'Carte mise à jour avec succès !');
    }

    /**
     * Remove the specified card from storage.
     */
    public function destroy(Flashcard $flashcard, Card $card)
    {
        // Check if the user owns this flashcard
        if ($flashcard->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $card->delete();
        
        return redirect()->route('flashcards.edit', $flashcard)
            ->with('success', 'Carte supprimée avec succès !');
    }
}
