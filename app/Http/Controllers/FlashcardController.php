<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashcardController extends Controller
{
    /**
     * Display a listing of the flashcards.
     */
    public function index(Request $request)
    {
        $flashcards = Auth::user()->flashcards()->latest()->paginate(10);
        
        // Créer une variable $flashcardSets comme collection vide au lieu d'un tableau
        $flashcardSets = collect([]); // Utiliser une collection Laravel
        
        // Récupérer les IDs des flashcards générées si disponibles
        $generatedFlashcards = session('generated_flashcards', []);
        
        return view('flashcards.index', compact('flashcards', 'flashcardSets', 'generatedFlashcards'));
    }

    /**
     * Display the specified flashcard.
     */
    public function show(Flashcard $flashcard)
    {
        // Vérifier que l'utilisateur a le droit d'accéder à cette flashcard
        if ($flashcard->user_id !== Auth::id() && $flashcard->visibilite !== 'publique') {
            abort(403, 'Unauthorized');
        }
        
        return view('flashcards.show', compact('flashcard'));
    }
}
