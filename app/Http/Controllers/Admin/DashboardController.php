<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Note;
use App\Models\SystemAlert;
use App\Models\AITransformation;
use App\Models\StudySession;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques utilisateurs
        $usersCount = User::count();
        $usersLastWeek = User::where('created_at', '>=', Carbon::now()->subWeek())->count();
        
        // Statistiques notes
        $notesCount = Note::count();
        $notesLastWeek = Note::where('created_at', '>=', Carbon::now()->subWeek())->count();
        
        // Statistiques transformations IA
        $aiTransformations = class_exists('App\Models\AITransformation') ? AITransformation::count() : 0;
        $aiLastWeek = class_exists('App\Models\AITransformation') ? AITransformation::where('created_at', '>=', Carbon::now()->subWeek())->count() : 0;
        
        // Statistiques heures d'étude
        $studyHours = class_exists('App\Models\StudySession') ? StudySession::sum('duration_minutes') / 60 : 0;
        $hoursLastWeek = class_exists('App\Models\StudySession') ? StudySession::where('created_at', '>=', Carbon::now()->subWeek())->sum('duration_minutes') / 60 : 0;
        
        // Alertes système récentes
        // Vérifier si le modèle SystemAlert existe
        if (class_exists('App\Models\SystemAlert')) {
            $alerts = SystemAlert::orderBy('created_at', 'desc')->take(3)->get();
        } else {
            $alerts = collect([]); // Collection vide si le modèle n'existe pas
        }
        
        // Utilisateurs récents
        $recentUsers = User::orderBy('created_at', 'desc')->take(3)->get();
        
        // Statistiques compilées
        $stats = [
            'users_count' => $usersCount,
            'users_weekly_change' => $usersLastWeek,
            'notes_count' => $notesCount,
            'notes_weekly_change' => $notesLastWeek,
            'ai_transformations' => $aiTransformations,
            'ai_weekly_change' => $aiLastWeek,
            'study_hours' => round($studyHours),
            'hours_weekly_change' => round($hoursLastWeek)
        ];
        
        // Dans la méthode index() de votre DashboardController
        
        // Récupérer les statistiques des matières
        $matieres = Note::select('matiere')
            ->whereNotNull('matiere')
            ->where('matiere', '!=', '')
            ->groupBy('matiere')
            ->selectRaw('matiere, count(*) as count')
            ->orderBy('count', 'desc')
            ->limit(6)
            ->get();
        
        $totalNotes = $matieres->sum('count') ?: 1; // Éviter la division par zéro
        $matiereStats = []; // Initialisation de la variable
        
        // Couleurs pour le graphique - Utiliser des codes hexadécimaux
        $colors = [
            '4F46E5', // bleu indigo pour Sciences
            '14B8A6', // turquoise pour Mathématiques
            'F97316', // orange pour Langues
            'DC2626', // rouge pour Histoire/Géo
            'A855F7', // violet pour Arts
            '94A3B8'  // gris pour Autres
        ];
        
        if ($totalNotes > 0) {
            foreach ($matieres as $index => $matiere) {
                $pourcentage = round(($matiere->count / $totalNotes) * 100);
                $matiereStats[] = [
                    'nom' => $matiere->matiere,
                    'count' => $matiere->count,
                    'pourcentage' => $pourcentage,
                    'color' => $colors[$index] ?? '9CA3AF' // Couleur par défaut si index hors limites
                ];
            }
            
            // Si moins de 6 matières, ajouter "Autres" pour le reste
            if (count($matiereStats) > 0 && count($matiereStats) < 6) {
                $matiereStats[] = [
                    'nom' => 'Autres',
                    'count' => 0,
                    'pourcentage' => 100 - array_sum(array_column($matiereStats, 'pourcentage')),
                    'color' => 'slate-300'
                ];
            }
        } else {
            // Ajouter une valeur par défaut si aucune matière n'est trouvée
            $matiereStats[] = [
                'nom' => 'Aucune donnée',
                'count' => 0,
                'pourcentage' => 100,
                'color' => 'gray-400'
            ];
        }
        
        // Passer les données à la vue
        return view('admin.dashboardAdmin', compact('stats', 'alerts', 'recentUsers', 'matiereStats'));
    }
}