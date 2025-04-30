<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FlashcardController extends Controller
{
    /**
     * Display a listing of the flashcard sets.
     */
    public function index()
    {
        // Récupérer les flashcards de l'utilisateur connecté
        $flashcardSets = Flashcard::where('user_id', auth()->id())->paginate(9);
        
        // Statistiques (à adapter selon votre structure de données)
        $stats = [
            'total' => 0,
            'revised' => 0,
            'progress' => 0
        ];
        
        return view('flashcards.index', compact('flashcardSets', 'stats'));
    }

    /**
     * Show the form for creating a new flashcard set.
     */
    public function create()
    {
        return view('flashcards.create');
    }

    /**
     * Store a newly created flashcard set in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'note_id' => 'nullable|exists:notes,id',
        ]);

        $flashcard = Auth::user()->flashcards()->create($data);

        return redirect()->route('flashcards.index')->with('success', 'Jeu de Flashcards créé !');
    }

    /**
     * Display the specified flashcard set.
     */
    public function show(Flashcard $flashcard)
    {
        // Remplacer la vérification de Gate par une simple vérification du propriétaire
        if ($flashcard->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('flashcards.show', compact('flashcard'));
    }

    /**
     * Show the form for editing the specified flashcard set.
     */
    public function edit(Flashcard $flashcard)
    {
        // Remplacer la vérification de Gate par une simple vérification du propriétaire
        if ($flashcard->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('flashcards.edit', compact('flashcard'));
    }

    /**
     * Update the specified flashcard set in storage.
     */
    public function update(Request $request, Flashcard $flashcard)
    {
        // Remplacer la vérification de Gate par une simple vérification du propriétaire
        if ($flashcard->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'note_id' => 'nullable|exists:notes,id',
            // Ajoutez ici les autres champs que vous souhaitez valider
        ]);

        $flashcard->update($data);

        return redirect()->route('flashcards.index')->with('success', 'Jeu de Flashcards mis à jour !');
    }

    /**
     * Remove the specified flashcard set from storage.
     */
    public function destroy(Flashcard $flashcard)
    {
        // Remplacer la vérification de Gate par une simple vérification du propriétaire
        if ($flashcard->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $flashcard->delete();

        return redirect()->route('flashcards.index')->with('success', 'Jeu de Flashcards supprimé !');
    }
}
