<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\Question;


class QuizController extends Controller
{
    /**
     * Display a listing of the quizzes.
     */
    public function index()
    {
        $quizzes = Auth::user()->quizzes()->latest()->paginate(10);
        return view('quizzes.index', compact('quizzes'));
    }
    

    /**
     * Show the form for creating a new quiz.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created quiz in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nombre_questions' => 'required|integer|min:0',
            'temps_limite' => 'nullable|integer|min:1',
            'statut' => ['required', Rule::in(['brouillon', 'publié', 'archivé'])],
            'note_id' => 'nullable|exists:notes,id',
        ]);
    
        // Créer le quiz une seule fois
        $quiz = new Quiz();
        $quiz->title = $validated['title'];
        $quiz->description = $validated['description'] ?? null;
        $quiz->statut = $validated['statut'];
        $quiz->nombre_questions = $validated['nombre_questions'];
        $quiz->temps_limite = $validated['temps_limite'] ?? null;
        $quiz->user_id = Auth::id();
        $quiz->save();
    
        return redirect()->route('quizzes.index')->with('success', 'Quiz créé avec succès !');
    }

    /**
     * Display the specified quiz.
     */
    public function show(Quiz $quiz)
    {
        // Commentez temporairement cette vérification
        // if (!Gate::allows('view-quiz', $quiz)) {
        //     abort(403, 'Unauthorized');
        // }
    
        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz.
     */
    public function edit(Quiz $quiz)
    {
        // Commentez temporairement cette vérification
        // if (!Gate::allows('update-quiz', $quiz)) {
        //     abort(403, 'Unauthorized');
        // }
    
        return view('quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified quiz in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        // Commentez temporairement cette vérification
        // if (!Gate::allows('update-quiz', $quiz)) {
        //     abort(403, 'Unauthorized');
        // }
    
        $request->validate([
            'title' => 'required|string|max:255',  // Changé de 'titre' à 'title'
            'description' => 'nullable|string',
            'note_id' => 'nullable|exists:notes,id',  // Changé de 'matiere_id' à 'note_id'
            'nombre_questions' => 'required|integer|min:0',
            'temps_limite' => 'nullable|integer|min:1',
            'statut' => ['required', Rule::in(['brouillon', 'publié', 'archivé'])],
        ]);
    
        $quiz->update($request->all());
    
        return redirect()->route('quizzes.index')->with('success', 'Quiz mis à jour avec succès !');
    }

    /**
     * Remove the specified quiz from storage.
     */
    public function destroy(Quiz $quiz)
    {
        // Commentez temporairement cette vérification
        // if (!Gate::allows('delete-quiz', $quiz)) {
        //     abort(403, 'Unauthorized');
        // }
    
        $quiz->delete();
    
        return redirect()->route('quizzes.index')->with('success', 'Quiz supprimé !');
    }
    public function createQuestion(Quiz $quiz)
    {
        // Commentez temporairement cette vérification
        // if (!Gate::allows('update-quiz', $quiz)) {
        //     abort(403, 'Unauthorized');
        // }
    
        return view('questions.create', compact('quiz'));
    }

    /**
     * Store a newly created question for the specified quiz in storage.
     */
    public function storeQuestion(Request $request, Quiz $quiz)
    {
        // Commentez temporairement cette vérification
        // if (!Gate::allows('update-quiz', $quiz)) {
        //     abort(403, 'Unauthorized');
        // }

        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string',
            'incorrect_answers' => 'nullable|array',
            'type' => ['required', Rule::in(['choix_multiple', 'vrai_faux', 'reponse_courte'])],
        ]);

        $quiz->questions()->create($request->all());

        // Mettre à jour le nombre de questions du quiz
        $quiz->update(['nombre_questions' => $quiz->questions()->count()]);

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Question ajoutée au quiz !');
    }

    /**
     * Show the form for editing the specified question for the specified quiz.
     */
    public function editQuestion(Quiz $quiz, Question $question)
    {
        // Commentez temporairement cette vérification
        // if (!Gate::allows('update-quiz', $quiz)) {
        //     abort(403, 'Unauthorized');
        // }

        return view('questions.edit', compact('quiz', 'question'));
    }

    /**
     * Update the specified question for the specified quiz in storage.
     */
    public function updateQuestion(Request $request, Quiz $quiz, Question $question)
    {
        // Commentez temporairement cette vérification
        // if (!Gate::allows('update-quiz', $quiz)) {
        //     abort(403, 'Unauthorized');
        // }

        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string',
            'incorrect_answers' => 'nullable|array',
            'type' => ['required', Rule::in(['choix_multiple', 'vrai_faux', 'reponse_courte'])],
        ]);

        $question->update($request->all());

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Question mise à jour !');
    }

    /**
     * Remove the specified question for the specified quiz from storage.
     */
    public function destroyQuestion(Quiz $quiz, Question $question)
    {
        // Commentez temporairement cette vérification
        // if (!Gate::allows('update-quiz', $quiz)) {
        //     abort(403, 'Unauthorized');
        // }

        $question->delete();

        // Mettre à jour le nombre de questions du quiz
        $quiz->update(['nombre_questions' => $quiz->questions()->count()]);

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Question supprimée !');
    }
}

