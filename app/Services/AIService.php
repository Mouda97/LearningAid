<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Services\ConnectionException;

class AIService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_GEMINI_API_KEY');
        // Mise à jour de l'URL de l'API pour utiliser le modèle gemini-1.5-flash
        $this->apiUrl = env('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent');
        
        // Vérifier si la clé API est configurée
        if (empty($this->apiKey)) {
            throw new Exception('Gemini API key is not configured. Please set GOOGLE_GEMINI_API_KEY in your .env file.');
        }
    }

    // Ajout de la méthode getApiUrl manquante
    protected function getApiUrl()
    {
        return $this->apiUrl;
    }

    // Ajout de la méthode buildFlashcardsPrompt manquante
    protected function buildFlashcardsPrompt($content, $numFlashcards)
    {
        return "Génère $numFlashcards flashcards basées sur le contenu suivant. Format JSON: {cards: [{front: 'question ou concept', back: 'réponse ou explication'}]}. Réponds uniquement avec le JSON, sans texte supplémentaire:\n\n" . $content;
    }

    // Ajout de la méthode parseFlashcardsResponse manquante
    protected function parseFlashcardsResponse($responseData)
    {
        // Extraire le texte de la réponse
        $text = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';
        
        // Nettoyer le texte pour extraire uniquement le JSON
        $text = preg_replace('/```json\s*|\s*```/', '', $text);
        $text = trim($text);
        
        // Décoder le JSON
        $flashcards = json_decode($text, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Failed to parse JSON response: ' . json_last_error_msg());
        }
        
        return $flashcards;
    }
        // fonction generate pour entrainner le comportement de la classe AIService sur ecoute des prompt
    public function generateQuizQuestions($content, $numQuestions, $questionType = 'choix_multiple')
    {
        // Adaptation du  prompt selon le type de question
        $promptPrefix = "Génère $numQuestions questions de type ";
        
        switch ($questionType) {
            case 'choix_multiple':
                $promptPrefix .= "choix multiple avec 1 réponse correcte et 3 réponses incorrectes. Format JSON: [{question: 'texte de la question', correct_answer: 'réponse correcte', incorrect_answers: ['réponse incorrecte 1', 'réponse incorrecte 2', 'réponse incorrecte 3']}]";
                break;
            case 'vrai_faux':
                $promptPrefix .= "vrai ou faux. Format JSON: [{question: 'texte de la question', correct_answer: 'Vrai' ou 'Faux', incorrect_answers: []}]";
                break;
            case 'reponse_court':
                $promptPrefix .= "réponse courte. Format JSON: [{question: 'texte de la question', correct_answer: 'réponse correcte', incorrect_answers: []}]";
                break;
            default:
                $promptPrefix .= "choix multiple";
        }
        
        $promptPrefix .= " basées sur le contenu suivant. Réponds uniquement avec le JSON, sans texte supplémentaire:\n\n";
        
        $prompt = $promptPrefix . $content;
        
        // Log pour déboguer l'envoir de la requette à l'API de Gemini google
        Log::info('Envoi de la requête à l\'API Gemini', [
            'url' => $this->apiUrl . '?key=' . substr($this->apiKey, 0, 5) . '...',
            'prompt_start' => substr($promptPrefix, 0, 100) . '...'
        ]);
        
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 8192,
                ]
            ]);
            
            // Log de la réponse pour déboguer 
            if ($response->failed()) {
                Log::error('Erreur API Gemini', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new Exception('API request failed: ' . $response->body());
            //retour de reponse si la requette echoue
            }
            //retour de reponse si la requette réussi( reponse envoiyer vers laravel sous format json)
            $responseData = $response->json();
            
            // Extraire le texte de la réponse
            $text = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            // Nettoyer le texte pour extraire uniquement le JSON
            $text = preg_replace('/```json\s*|\s*```/', '', $text);
            $text = trim($text);
            
            // Décoder le JSON
            $questions = json_decode($text, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Failed to parse JSON response: ' . json_last_error_msg());
            }
            
            return $questions;
            
        } catch (Exception $e) {
            Log::error('Erreur lors de la génération des questions', [
                'error' => $e->getMessage()
            ]);
            throw new Exception('Error generating quiz questions: ' . $e->getMessage());
        }
    }

    /**
     * Génère des flashcards basées sur le contenu fourni
     * 
     * @param string $content Le contenu à partir duquel générer les flashcards
     * @param int $numFlashcards Le nombre de flashcards à générer
     * @return array Les données des flashcards générées
     */
    /**
     * Génère des flashcards à partir du contenu d'une note
     */
    public function generateFlashcards($content, $numFlashcards = 5)
    {
        try {
            // Augmenter le timeout pour la requête HTTP
            $response = Http::timeout(60) // Augmenter le timeout à 60 secondes
                ->withOptions([
                    'verify' => false, // Désactiver la vérification SSL si nécessaire
                    'connect_timeout' => 30, // Timeout de connexion
                ])
                ->post($this->getApiUrl(), [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $this->buildFlashcardsPrompt($content, $numFlashcards)
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.2,
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 8192,
                    ]
                ]);
    
            // Vérifier si la requête a réussi
            if ($response->successful()) {
                $data = $response->json();
                return $this->parseFlashcardsResponse($data);
            } else {
                Log::error('Erreur API Gemini', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('API request failed: ' . $response->body());
            }
        } catch (ConnectionException $e) {
            Log::error('Erreur de connexion à l\'API Gemini', [
                'error' => $e->getMessage()
            ]);
            
            // Essayer avec une méthode alternative (modèle plus léger)
            try {
                $response = Http::timeout(60)
                    ->withOptions([
                        'verify' => false,
                        'connect_timeout' => 30,
                    ])
                    ->post(str_replace('gemini-1.5-flash', 'gemini-1.0-pro', $this->getApiUrl()), [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $this->buildFlashcardsPrompt($content, $numFlashcards)
                                    ]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.2,
                            'maxOutputTokens' => 4096,
                        ]
                    ]);
                    
                if ($response->successful()) {
                    $data = $response->json();
                    return $this->parseFlashcardsResponse($data);
                }
            } catch (\Exception $fallbackError) {
                Log::error('Échec de la méthode alternative', [
                    'error' => $fallbackError->getMessage()
                ]);
            }
            
            throw new \Exception('Error generating flashcards: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération des flashcards', [
                'error' => $e->getMessage()
            ]);
            throw new \Exception('Error generating flashcards: ' . $e->getMessage());
        }
    }
}