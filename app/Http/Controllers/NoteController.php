<?php
    namespace App\Http\Controllers;

        use App\Models\Note;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Str;
        use Illuminate\Support\Facades\DB;
        use Illuminate\Support\Facades\Log;
        

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