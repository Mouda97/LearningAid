<?php
    namespace App\Http\Controllers;

        use App\Models\Note;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Str;
        use Illuminate\Support\Facades\DB;
        use Illuminate\Support\Facades\Log;
        use Illuminate\Support\Facades\Redirect;
        use Illuminate\Support\Facades\Http; // Importe le client HTTP de Laravel
        use Illuminate\Http\Client\ConnectionException; // Pour attraper les erreurs de connexion
        use App\Models\Quiz;
        use App\Models\Question;
        use \JsonException; // Correct import for JsonException

        

        class NoteController extends Controller
        {
            /**
             * Display a listing of the notes.
             */
            public function index()
            {
                try {
                    // Make sure we're getting the latest notes
                    $notes = Auth::user()->notes()->latest()->paginate(10);
                    
                    // Debug the notes to see what's being returned
                    \Log::info('Notes retrieved: ' . $notes->count());
                    
                    // Récupérer les matières avec le nombre de notes pour chacune
                    $matieres = DB::table('notes')
                        ->select('matiere', DB::raw('count(*) as notes_count'), DB::raw('MAX(updated_at) as derniere_modif'))
                        ->where('user_id', Auth::id())
                        ->groupBy('matiere')
                        ->get()
                        ->map(function($item) {
                            $item->nom = $item->matiere;
                            // Formater la date de dernière modification
                            $date = new \Carbon\Carbon($item->derniere_modif);
                            if ($date->isToday()) {
                                $item->derniere_modif = "Aujourd'hui";
                            } elseif ($date->isYesterday()) {
                                $item->derniere_modif = "Hier";
                            } else {
                                $item->derniere_modif = "Il y a " . $date->diffInDays() . "j";
                            }
                            return $item;
                        });
                    
                    return view('notes.index', compact('notes', 'matieres'));
                } catch (\Exception $e) {
                    \Log::error('Erreur dans NoteController@index: ' . $e->getMessage());
                    return view('notes.index', [
                        'notes' => collect([]),
                        'error' => 'Une erreur est survenue lors du chargement des notes.'
                    ]);
                }
            }

            /**
             * Show the form for creating a new note.
             */
            public function create()
            {
                return view('notes.create');
            }

            /**
             * Store a newly created note in storage.
             */
            public function store(Request $request)
            {
                $request->validate([
                    'title' => 'required|string|max:255',
                    'content' => 'required|string',
                    'matiere' => 'nullable|string|max:255',
                    'statut' => ['nullable', 'string', 'in:brouillon,publiee,archivee,en_transformation'],
                    'niveau_visibilite' => ['nullable', 'string', 'in:prive,groupe,public'],
                ]);
            
                // Vérifiez que tous les champs nécessaires sont présents dans la requête
                $data = [
                    'title' => $request->title,
                    'content' => $request->content,
                    'matiere' => $request->matiere ?? 'Non classé', // Valeur par défaut si matiere est null
                    'statut' => $request->statut ?? 'brouillon',
                    'niveau_visibilite' => $request->niveau_visibilite ?? 'prive',
                ];
            
                // Créer la note avec les données validées
                Auth::user()->notes()->create($data);
            
                return redirect('/notes')->with('success', 'Note créée avec succès !');
            }

            /**
             * Display the specified note.
             */
            public function show(Note $note)
            {
                if ($note->user_id !== Auth::id()) {
                    abort(403, 'Unauthorized'); // Empêche un utilisateur d'accéder aux notes d'un autre utilisateur
                }
                return view('notes.show', compact('note'));
            }

            /**
             * Show the form for editing the specified note.
             */
            public function edit(Note $note)
            {
                if ($note->user_id !== Auth::id()) {
                    abort(403, 'Unauthorized');
                }
                return view('notes.edit', compact('note'));
            }

            /**
             * Update the specified note in storage.
             */
        
            public function update(Request $request, Note $note)
            {
                if ($note->user_id !== Auth::id()) {
                    abort(403, 'Unauthorized');
                }
// valider les données de la requête
                // $request->validate([
                //     'title' => 'required|string|max:255',
                //     'content' => 'required|string',
                //     'matiere' => 'nullable|string|max:255',
                //    'status' => 'nullable|enum|max:255',
                //     'niveau_visibilite'=> 'nullable|enum|max:255'
                // ]);'brouillon', 'publiee', 'archivee', 'en_transformation'
                $request->validate([
                    'title' => 'required|string|max:255',
                    'content' => 'required|string',
                    'matiere' => 'nullable|string|max:255',
                    'statut' => ['nullable', 'string', 'in:brouillon,publiee,archivee,en_transformation'],
                    'niveau_visibilite' => ['nullable', 'string', 'in:prive,groupe,public'], // Suppression des espaces
                ]);
// modifier les champs de la note
                $note->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'matiere' => $request->matiere,
                   'statut' => $request->statut,
                    'niveau_visibilite'=> $request->niveau_visibilite,
                ]);

                return redirect('/notes')->with('success', 'Note mise à jour avec succès !');
            }

            /**
             * Remove the specified note from storage.
             */
            public function destroy(Note $note)
            {
                if ($note->user_id !== Auth::id()) {
                    abort(403, 'Unauthorized');
                }

                $note->delete();

                return redirect('/notes')->with('success', 'Note supprimée !');
            }

            /**
                         
             * Import notes from various file types (TXT, PDF, DOC).
             */
            public function importTxt(Request $request)
            {
                $request->validate([
                    'file' => 'required|file|mimes:txt,pdf,doc,docx',
                ]);
            
                $file = $request->file('file');
                $fileExtension = $file->getClientOriginalExtension();
                $content = '';
                $title = '';
            
                // Traitement selon le type de fichier
                if ($fileExtension === 'txt') {
                    // Traitement des fichiers TXT
                    $content = file_get_contents($file->getRealPath());
                    $title = Str::limit(explode("\n", $content)[0], 255);
                } 
                elseif (in_array($fileExtension, ['pdf'])) {
                    // Pour les PDF, vous aurez besoin d'une bibliothèque comme pdfparser
                    // Exemple d'utilisation avec la bibliothèque Smalot\PdfParser
                    // Vous devez d'abord l'installer : composer require smalot/pdfparser
                    try {
                        // Si vous avez installé la bibliothèque, décommentez ces lignes
                        // $parser = new \Smalot\PdfParser\Parser();
                        // $pdf = $parser->parseFile($file->getRealPath());
                        // $content = $pdf->getText();
                        // $title = Str::limit($content, 255);
                        
                        // En attendant, utilisez ceci comme solution temporaire
                        $title = $file->getClientOriginalName();
                        $content = "Contenu importé depuis un fichier PDF: " . $title;
                    } catch (\Exception $e) {
                        return redirect('/notes')->with('error', 'Erreur lors de l\'analyse du PDF: ' . $e->getMessage());
                    }
                } 
                elseif (in_array($fileExtension, ['doc', 'docx'])) {
                    // Pour les DOC/DOCX, vous aurez besoin d'une bibliothèque comme phpoffice/phpword
                    // Exemple : composer require phpoffice/phpword
                    try {
                        // Si vous avez installé la bibliothèque, décommentez ces lignes
                        // $phpWord = \PhpOffice\PhpWord\IOFactory::load($file->getRealPath());
                        // $content = '';
                        // foreach ($phpWord->getSections() as $section) {
                        //     foreach ($section->getElements() as $element) {
                        //         if (method_exists($element, 'getText')) {
                        //             $content .= $element->getText() . "\n";
                        //         }
                        //     }
                        // }
                        // $title = Str::limit($content, 255);
                        
                        // En attendant, utilisez ceci comme solution temporaire
                        $title = $file->getClientOriginalName();
                        $content = "Contenu importé depuis un fichier Word: " . $title;
                    } catch (\Exception $e) {
                        return redirect('/notes')->with('error', 'Erreur lors de l\'analyse du document Word: ' . $e->getMessage());
                    }
                }
            
                // Créer la note avec le contenu extrait
                Auth::user()->notes()->create([
                    'title' => $title,
                    'content' => $content,
                    'statut' => $request->statut ?? 'brouillon',
                    'niveau_visibilite' => $request->niveau_visibilite ?? 'prive',
                    'matiere' => $request->matiere ?? null,
                ]);
            
                return redirect('/notes')->with('success', 'Document importé avec succès !');
            }


            /**
     
            * Déclenche la génération d'un Quiz par IA pour une note spécifique.
            */
            /**
 * Déclenche la génération d'un Quiz par IA pour une note spécifique via l'API Google Gemini.
 */
            public function generateQuiz(Note $note)
            {
                // Récupérer la clé API depuis le .env
                $apiKey = env('GOOGLE_GEMINI_API_KEY');
                if (!$apiKey) {
                    return Redirect::route('notes.show', $note)->with('error', 'Clé API Google Gemini non configurée dans le fichier .env.');
                }

                // 1. Vérifications initiales
                if ($note->user_id !== auth()->id()) {
                    abort(403, 'Action non autorisée.');
                }
                if (empty($note->content)) {
                    return Redirect::route('notes.show', $note)->with('error', 'Impossible de générer un quiz : la note est vide.');
                }

                $noteContent = $note->content;
                // Instruction pour Gemini (on peut être plus direct)
                // On demande explicitement du JSON.
                $prompt = "Basé sur le texte suivant, génère un quiz de 3 questions à choix multiples (QCM).\n\n"
                        . "FORMAT DE SORTIE ATTENDU :\n"
                        . "Un unique bloc de code JSON valide contenant un objet avec une clé 'quiz_title' (string) et une clé 'questions' (tableau d'objets). Chaque objet question doit avoir les clés : 'question' (string), 'options' (objet avec clés A, B, C, D contenant les strings des réponses), et 'correct_answer' (string contenant la lettre A, B, C ou D de la bonne réponse).\n\n"
                        . "TEXTE DE RÉFÉRENCE :\n"
                        . $noteContent;

                // Modèle Gemini à utiliser (Flash est rapide et souvent suffisant)
                $model = 'gemini-1.5-flash-latest'; // Ou 'gemini-1.5-pro-latest' pour plus de puissance
                $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

                // Corps de la requête pour l'API Gemini
                $requestBody = [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    // Options de génération (optionnel, pour contrôler la sortie)
                    // 'generationConfig' => [
                    //     'temperature' => 0.7,
                    //     'topK' => 40,
                    //     'topP' => 0.95,
                    //     'maxOutputTokens' => 1024,
                    // ],
                    // Configuration de sécurité (optionnel, pour ajuster les blocages)
                    'safetySettings' => [
                        ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
                        ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
                        ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
                        ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
                    ]
                ];

                Log::info('Envoi de la requête à l\'API Gemini.', ['url' => $apiUrl, 'prompt_start' => substr($prompt, 0, 100) . '...']);

                try {
                    // Envoyer la requête POST à l'API Google Gemini
                    $response = Http::timeout(120)->post($apiUrl, $requestBody);

                    // Gérer la réponse de l'API Gemini
                    if ($response->successful()) {
                        $responseData = $response->json();

                        // Extraire le texte généré (la structure peut varier légèrement)
                        $generatedText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;

                        if (!$generatedText) {
                            Log::error('Réponse de l\'API Gemini vide ou structure inattendue.', ['response' => $responseData]);
                            return Redirect::route('notes.show', $note)->with('error', 'Réponse vide ou inattendue reçue de l\'IA Gemini.');
                        }

                        Log::info('Réponse brute (texte généré) reçue de Gemini: ' . $generatedText);

                        // --- Le reste du code pour décoder le JSON et créer le Quiz/Questions ---
                        // (Ce code est presque identique à avant, car on s'attend toujours à recevoir du JSON)
                        $quizData = null;
                        try {
                            // Essayer de nettoyer un peu la réponse si elle contient des ```json ... ```
                            $cleanedJson = preg_replace('/^```json\s*|```\s*$/', '', $generatedText);

                            if (Str::isJson($cleanedJson)) {
                                $quizData = json_decode($cleanedJson, true, 512, JSON_THROW_ON_ERROR);
                                Log::info('JSON de Gemini décodé avec succès.', ['data' => $quizData]);
                            } else {
                                Log::error('La réponse de Gemini n\'est pas un JSON valide.', ['raw_response' => $generatedText, 'cleaned' => $cleanedJson]);
                                throw new JsonException('Format JSON invalide reçu de l\'IA Gemini.');
                            }
                        } catch (\JsonException $e) {
                            Log::error('Erreur de décodage JSON de la réponse Gemini.', ['error' => $e->getMessage(), 'raw_response' => $generatedText]);
                            return Redirect::route('notes.show', $note)
                                    ->with('error', 'Erreur lors de l\'analyse de la réponse de l\'IA Gemini. Format JSON attendu incorrect. (' . $e->getMessage() . ')');
                        }

                        if (!isset($quizData['quiz_title']) || !isset($quizData['questions']) || !is_array($quizData['questions'])) {
                            Log::error('Structure JSON invalide reçue de Gemini.', ['decoded_data' => $quizData]);
                            return Redirect::route('notes.show', $note)
                                    ->with('error', 'La structure de la réponse de l\'IA Gemini est incorrecte.');
                        }

                        // Enregistrer en BDD (Transaction) - Identique à avant
                        $newQuiz = null;
                        try {
                            // Dans la méthode qui gère la création du quiz (probablement generateQuiz ou une méthode similaire)
                            DB::transaction(function () use ($quizData, $note, &$newQuiz) {
                                Log::info('Début de la transaction DB pour création de quiz');
                                
                                // Création du quiz
                                $newQuiz = Quiz::create([
                                    'title' => $quizData['quiz_title'],
                                    'description' => 'Quiz généré par IA (Gemini) depuis la note "' . $note->title . '".',
                                    'user_id' => auth()->id(),
                                    'note_id' => $note->id,
                                ]);
                                
                                Log::info('Quiz créé avec succès', ['quiz_id' => $newQuiz->id]);
                                
                                // Création des questions
                                foreach ($quizData['questions'] as $index => $qData) {
                                    Log::info('Traitement de la question', ['index' => $index]);
                                    
                                    // Récupérer les options et la réponse correcte
                                    $options = $qData['options'];
                                    $correctAnswer = $qData['correct_answer'];
                                    
                                    // Créer un tableau des réponses incorrectes
                                    $incorrectAnswers = [];
                                    foreach ($options as $key => $value) {
                                        if ($key !== $correctAnswer) {
                                            $incorrectAnswers[] = $value;
                                        }
                                    }
                                    
                                    // Créer la question avec tous les champs requis
                                    Question::create([
                                        'quiz_id' => $newQuiz->id,
                                        'question_text' => $qData['question'],
                                        'correct_answer' => $options[$correctAnswer], // Stocker le texte de la réponse correcte
                                        'incorrect_answers' => json_encode($incorrectAnswers) // Convertir le tableau en JSON
                                    ]);
                                }
                            });
                        } catch (\Exception $e) {
                            Log::error('Erreur BDD lors de la création du Quiz/Questions (Gemini).', ['error' => $e->getMessage()]);
                            if ($newQuiz && $newQuiz->exists) $newQuiz->delete();
                            return Redirect::route('notes.show', $note)->with('error', 'Erreur BDD lors de l\'enregistrement du quiz (Gemini).');
                        }

                        // Redirection succès - Identique à avant
                        if ($newQuiz && $newQuiz->exists && $newQuiz->questions()->count() > 0) {
                            return Redirect::route('quizzes.show', $newQuiz)->with('status', 'Quiz généré par l\'IA Gemini et enregistré !');
                        } else {
                            if ($newQuiz && $newQuiz->exists) $newQuiz->delete(); // Nettoyer si pas de questions valides
                            return Redirect::route('notes.show', $note)->with('error', 'Quiz généré (Gemini) mais aucune question valide trouvée ou erreur d\'enregistrement.');
                        }

                    } else {
                        // Gérer les erreurs spécifiques de l'API Google (ex: clé invalide, quota dépassé...)
                        $errorDetails = $response->json()['error'] ?? ['message' => 'Erreur inconnue de l\'API Google.'];
                        Log::error('Erreur de l\'API Google Gemini.', ['status' => $response->status(), 'details' => $errorDetails]);
                        return Redirect::route('notes.show', $note)
                                ->with('error', 'Erreur de l\'API Google : ' . $response->status() . ' - ' . ($errorDetails['message'] ?? 'Détails indisponibles.'));
                    }

                } catch (ConnectionException $e) {
                    // Gérer les erreurs de connexion réseau
                    report($e);
                    return Redirect::route('notes.show', $note)->with('error', 'Impossible de contacter l\'API Google Gemini. Vérifiez la connexion internet.');
                } catch (\Exception $e) {
                    // Gérer toute autre erreur inattendue
                    report($e);
                    return Redirect::route('notes.show', $note)->with('error', 'Une erreur inattendue est survenue lors de l\'appel à l\'IA.');
                }
            }

// ... (generateFlashcards - à adapter de manière similaire - et autres méthodes) ...


            /**
             * Déclenche la génération de Flashcards par IA pour une note spécifique.
             */
            public function generateFlashcards(Note $note)
            {
                // 1. Vérification simple : l'utilisateur connecté est-il propriétaire de la note ?
                if ($note->user_id !== auth()->id()) {
                    abort(403, 'Action non autorisée.');
                    // Gate::authorize('update', $note);
                }

                // 2. Vérifier si la note a du contenu
                if (empty($note->content)) {
                    return Redirect::route('notes.show', $note)
                                ->with('error', 'Impossible de générer des flashcards : la note est vide.');
                }

                $noteContent = $note->content;
                // Instruction T5 pour générer des paires recto/verso
                $instruction = "Extrait 5 concepts ou faits clés du texte suivant et génère des flashcards (paires recto/verso) pour chacun. Formatte le résultat en JSON de cette manière : {\"flashcard_title\": \"Titre du Jeu\", \"cards\": [{\"front\": \"Recto1\", \"back\": \"Verso1\"}, {\"front\": \"Recto2\", \"back\": \"Verso2\"}, ...]} : ";

                // --- Appel à l'API Flask (Prochaine étape !) ---
                // $response = Http::timeout(120)->post('http://127.0.0.1:5001/generate', [
                //     'instruction' => $instruction,
                //     'text' => $noteContent,
                // ]);
                // ... gestion de la réponse ...
                // ---

                // 3. Redirection temporaire en attendant l'appel API
                return Redirect::route('notes.show', $note)
                        ->with('status', 'Flashcards IA : Connexion au service IA et traitement en cours...');
            }
        }
                // <!-- ```

                // * `index()` : Récupère et affiche toutes les notes de l'utilisateur connecté, avec pagination.
                // * `create()` : Affiche le formulaire de création de note.
                // * `store(Request $request)` : Valide les données du formulaire et crée une nouvelle note.
                // * `show(Note $note)` : Affiche une note spécifique. Vérifie si l'utilisateur a le droit d'accéder à cette note.
                // * `edit(Note $note)` : Affiche le formulaire de modification d'une note. Vérifie l'autorisation.
                // * `update(Request $request, Note $note)` : Valide les données et met à jour une note existante. Vérifie l'autorisation.
                // * `destroy(Note $note)` : Supprime une note. Vérifie l'autorisation.
                // * `importTxt(Request $request)` : Importe les notes depuis un fichier TXT. -->