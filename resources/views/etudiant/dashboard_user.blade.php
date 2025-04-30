@extends('etudiant.baseE')
@section('content')
<!-- Contenu principal -->
<main class="flex-1 p-6">
    <!-- Titre et bienvenue -->
    <div class="mb-8">
        <h2 class="font-poppins font-bold text-2xl text-[#1767A4]">Tableau de bord</h2>
        <p class="text-gray-700">Bienvenue, {{ Auth::user()->name }}! Voici un aperçu de vos activités d'apprentissage.</p>
    </div>
    
    <!-- Cartes statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="font-poppins font-semibold text-base text-[#1767A4] mb-2">Notes créées</h3>
            <div class="flex items-baseline">
                <span class="font-poppins font-bold text-3xl text-gray-700">24</span>
                <span class="ml-2 text-sm text-green-500">+3 cette semaine</span>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="font-poppins font-semibold text-base text-[#1767A4] mb-2">Quiz complétés</h3>
            <div class="flex items-baseline">
                <span class="font-poppins font-bold text-3xl text-gray-700">17</span>
                <span class="ml-2 text-sm text-green-500">+5 cette semaine</span>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="font-poppins font-semibold text-base text-[#1767A4] mb-2">Flashcards révisées</h3>
            <div class="flex items-baseline">
                <span class="font-poppins font-bold text-3xl text-gray-700">42</span>
                <span class="ml-2 text-sm text-green-500">+12 cette semaine</span>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="font-poppins font-semibold text-base text-[#1767A4] mb-2">Temps d'étude</h3>
            <div class="flex items-baseline">
                <span class="font-poppins font-bold text-3xl text-gray-700">8h</span>
                <span class="ml-2 text-sm text-green-500">+2h vs semaine dernière</span>
            </div>
        </div>
    </div>
    
    <!-- Mes matières -->
    <h3 class="font-poppins font-bold text-xl text-[#1767A4] mb-4">Mes matières</h3>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        <!-- Carte Biologie -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="h-2 bg-[#4C51BF]"></div>
            <div class="p-6">
                <h4 class="font-poppins font-semibold text-base text-gray-700 mb-1">Biologie</h4>
                <p class="text-sm text-gray-700 mb-4">8 notes · 4 quiz · 16 flashcards</p>
                
                <div class="w-full bg-gray-50 rounded-full h-2 mb-2">
                    <div class="bg-[#4C51BF] h-2 rounded-full" style="width: 75%"></div>
                </div>
                <p class="text-sm text-gray-700 mb-6">75% du programme étudié</p>
                
                <button class="bg-[#FF5714] text-white text-xs font-medium py-2 px-6 rounded-full float-right">
                    Continuer
                </button>
            </div>
        </div>
        
        <!-- Carte Chimie -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="h-2 bg-[#ED8936]"></div>
            <div class="p-6">
                <h4 class="font-poppins font-semibold text-base text-gray-700 mb-1">Chimie</h4>
                <p class="text-sm text-gray-700 mb-4">6 notes · 5 quiz · 14 flashcards</p>
                
                <div class="w-full bg-gray-50 rounded-full h-2 mb-2">
                    <div class="bg-[#ED8936] h-2 rounded-full" style="width: 60%"></div>
                </div>
                <p class="text-sm text-gray-700 mb-6">60% du programme étudié</p>
                
                <button class="bg-[#FF5714] text-white text-xs font-medium py-2 px-6 rounded-full float-right">
                    Continuer
                </button>
            </div>
        </div>
        
        <!-- Carte Mathématiques -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="h-2 bg-[#38B2AC]"></div>
            <div class="p-6">
                <h4 class="font-poppins font-semibold text-base text-gray-700 mb-1">Mathématiques</h4>
                <p class="text-sm text-gray-700 mb-4">10 notes · 8 quiz · 12 flashcards</p>
                
                <div class="w-full bg-gray-50 rounded-full h-2 mb-2">
                    <div class="bg-[#38B2AC] h-2 rounded-full" style="width: 80%"></div>
                </div>
                <p class="text-sm text-gray-700 mb-6">80% du programme étudié</p>
                
                <button class="bg-[#FF5714] text-white text-xs font-medium py-2 px-6 rounded-full float-right">
                    Continuer
                </button>
            </div>
        </div>
    </div>
    
    <!-- Activité récente et suggestions IA -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Activité récente -->
        <div class="xl:col-span-2 bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="font-poppins font-bold text-xl text-[#1767A4] mb-4">Activité récente</h3>
            
            <div class="divide-y divide-gray-200">
                <!-- Activité 1 -->
                <div class="py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-[#1767A4] mr-4"></div>
                            <p class="text-sm font-medium text-gray-700">Quiz complété: Les organites cellulaires</p>
                        </div>
                        <span class="text-sm text-gray-400">Il y a 2 heures</span>
                    </div>
                </div>
                
                <!-- Activité 2 -->
                <div class="py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-[#FF5714] mr-4"></div>
                            <p class="text-sm font-medium text-gray-700">Note transformée: Équations chimiques</p>
                        </div>
                        <span class="text-sm text-gray-400">Hier</span>
                    </div>
                </div>
                
                <!-- Activité 3 -->
                <div class="py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-[#5D9CEC] mr-4"></div>
                            <p class="text-sm font-medium text-gray-700">Flashcards créées: Formules mathématiques</p>
                        </div>
                        <span class="text-sm text-gray-400">Hier</span>
                    </div>
                </div>
                
                <!-- Activité 4 -->
                <div class="py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-[#10B981] mr-4"></div>
                            <p class="text-sm font-medium text-gray-700">Nouvelle note: Introduction à la physique</p>
                        </div>
                        <span class="text-sm text-gray-400">Il y a 2 jours</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Suggestions IA -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="bg-[#1767A4] text-white p-4">
                <h3 class="font-poppins font-semibold text-base">Suggestions IA</h3>
            </div>
            
            <div class="p-4 space-y-4">
                <div class="bg-blue-50 border border-blue-300 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-[#1767A4]">Réviser les flashcards Biologie</h4>
                    <p class="text-xs text-gray-700 mt-1">Dernier accès: il y a 3 jours</p>
                </div>
                
                <div class="bg-blue-50 border border-blue-300 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-[#1767A4]">Terminer le quiz Chimie organique</h4>
                    <p class="text-xs text-gray-700 mt-1">Commencé il y a 1 jour</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bouton Créer une note rapide (mobile) -->
    <div class="fixed bottom-6 right-6 md:hidden">
        <button class="bg-[#FF5714] text-white text-xs font-medium py-2 px-4 rounded-full flex items-center">
            <span class="w-5 h-5 rounded-full bg-white flex items-center justify-center mr-1">
                <span class="text-[#FF5714] font-bold text-xs">+</span>
            </span>
            Note
        </button>
    </div>
    
    <!-- Bouton Créer une note rapide (desktop) -->
    <div class="hidden md:block absolute bottom-6 right-6">
        <button class="bg-[#FF5714] text-white text-xs font-medium py-2 px-4 rounded-full flex items-center">
            <span class="w-5 h-5 rounded-full bg-white flex items-center justify-center mr-1">
                <span class="text-[#FF5714] font-bold text-xs">+</span>
            </span>
            Note
        </button>
    </div>
</main>
</div>
</div>
@endsection
{{-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
</head>
<body>
    <h1>Tableau de Bord</h1>

    <p>Bienvenue, {{ Auth::user()->name }} !</p>

    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Se déconnecter</button>
    </form>

    </body>
</html> --}}