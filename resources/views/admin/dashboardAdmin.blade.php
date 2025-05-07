@extends('admin/baseA')
@section('content')
<!-- Contenu principal -->
<main class="flex-1 p-6">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-[#1767A4] font-['Poppins']">Tableau de bord administrateur</h2>
        <p class="text-slate-700 mt-1">Vue d'ensemble et statistiques de la plateforme d'apprentissage</p>
    </div>
    
    <!-- Cartes statistiques -->
    <div class="grid grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
            <h3 class="text-[#1767A4] font-semibold text-lg mb-4 font-['Poppins']">Étudiants actifs</h3>
            <div class="flex items-end">
                <span class="text-4xl font-bold text-slate-700 font-['Poppins']">{{ $stats['users_count'] ?? 0 }}</span>
                <span class="ml-2 text-sm {{ ($stats['users_weekly_change'] ?? 0) > 0 ? 'text-emerald-500' : 'text-red-500' }}">
                    {{ ($stats['users_weekly_change'] ?? 0) > 0 ? '+' : '' }}{{ $stats['users_weekly_change'] ?? 0 }} cette semaine
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-2">Étudiants inscrits et régulièrement connectés</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
            <h3 class="text-[#1767A4] font-semibold text-lg mb-4 font-['Poppins']">Contenus IA générés</h3>
            <div class="flex items-end">
                <span class="text-4xl font-bold text-slate-700 font-['Poppins']">{{ $stats['ai_transformations'] ?? 0 }}</span>
                <span class="ml-2 text-sm {{ ($stats['ai_weekly_change'] ?? 0) > 0 ? 'text-emerald-500' : 'text-red-500' }}">
                    {{ ($stats['ai_weekly_change'] ?? 0) > 0 ? '+' : '' }}{{ $stats['ai_weekly_change'] ?? 0 }} cette semaine
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-2">Quiz et flashcards générés par l'IA</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
            <h3 class="text-[#1767A4] font-semibold text-lg mb-4 font-['Poppins']">Notes étudiants</h3>
            <div class="flex items-end">
                <span class="text-4xl font-bold text-slate-700 font-['Poppins']">{{ $stats['notes_count'] ?? 0 }}</span>
                <span class="ml-2 text-sm {{ ($stats['notes_weekly_change'] ?? 0) > 0 ? 'text-emerald-500' : 'text-red-500' }}">
                    {{ ($stats['notes_weekly_change'] ?? 0) > 0 ? '+' : '' }}{{ $stats['notes_weekly_change'] ?? 0 }} cette semaine
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-2">Notes créées ou importées par les étudiants</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
            <h3 class="text-[#1767A4] font-semibold text-lg mb-4 font-['Poppins']">Heures d'étude</h3>
            <div class="flex items-end">
                <span class="text-4xl font-bold text-slate-700 font-['Poppins']">{{ $stats['study_hours'] ?? 0 }}</span>
                <span class="ml-2 text-sm {{ ($stats['hours_weekly_change'] ?? 0) > 0 ? 'text-emerald-500' : 'text-red-500' }}">
                    {{ ($stats['hours_weekly_change'] ?? 0) > 0 ? '+' : '' }}{{ $stats['hours_weekly_change'] ?? 0 }} cette semaine
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-2">Temps total passé sur la plateforme</p>
        </div>
    </div>
    
    <div class="grid grid-cols-3 gap-6">
        <!-- Graphique d'activité -->
        <div class="col-span-2 bg-white rounded-lg border border-slate-200 shadow-sm p-6">
            <h3 class="text-[#1767A4] font-semibold text-lg mb-4 font-['Poppins']">Activité utilisateurs</h3>
            <div class="bg-slate-50 rounded p-4 h-64">
                <div class="relative h-full">
                    <!-- Axe Y -->
                    <div class="absolute left-0 top-0 h-full border-r border-slate-200 flex flex-col justify-between text-xs text-slate-400 py-2">
                        <span>1500</span>
                        <span>1000</span>
                        <span>500</span>
                        <span>0</span>
                    </div>
                    
                    <!-- Graphique -->
                    <div class="ml-8 h-full flex items-end justify-between">
                        <div class="h-3/5 w-5 bg-[#1767A4] opacity-80 rounded"></div>
                        <div class="h-4/5 w-5 bg-[#1767A4] opacity-80 rounded"></div>
                        <div class="h-5/6 w-5 bg-[#1767A4] opacity-80 rounded"></div>
                        <div class="h-4/5 w-5 bg-[#1767A4] opacity-80 rounded"></div>
                        <div class="h-3/4 w-5 bg-[#1767A4] opacity-80 rounded"></div>
                        <div class="h-2/5 w-5 bg-[#1767A4] opacity-80 rounded"></div>
                        <div class="h-1/3 w-5 bg-[#1767A4] opacity-80 rounded"></div>
                    </div>
                    
                    <!-- Ligne de tendance (superposition) -->
                    <div class="absolute inset-0 ml-8 flex items-end justify-between pointer-events-none">
                        <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 40 L16.7 20 L33.3 10 L50 30 L66.7 30 L83.3 60 L100 70" stroke="#FF5714" stroke-width="2" fill="none" />
                            <circle cx="0" cy="40" r="2" fill="#FF5714" />
                            <circle cx="16.7" cy="20" r="2" fill="#FF5714" />
                            <circle cx="33.3" cy="10" r="2" fill="#FF5714" />
                            <circle cx="50" cy="30" r="2" fill="#FF5714" />
                            <circle cx="66.7" cy="30" r="2" fill="#FF5714" />
                            <circle cx="83.3" cy="60" r="2" fill="#FF5714" />
                            <circle cx="100" cy="70" r="2" fill="#FF5714" />
                        </svg>
                    </div>
                </div>
                
                <!-- Axe X -->
                <div class="mt-2 flex justify-between text-xs text-slate-400">
                    <span>Lun</span>
                    <span>Mar</span>
                    <span>Mer</span>
                    <span>Jeu</span>
                    <span>Ven</span>
                    <span>Sam</span>
                    <span>Dim</span>
                </div>
            </div>
            
            <!-- Légende -->
            <div class="mt-4 flex items-center space-x-6">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-[#1767A4] opacity-80 mr-2"></div>
                    <span class="text-sm text-slate-700">Sessions quotidiennes</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-[#FF5714] mr-2"></div>
                    <span class="text-sm text-slate-700">Tendance hebdomadaire</span>
                </div>
            </div>
        </div>
        
        <!-- Distribution des matières -->
        <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-6">
            <h3 class="text-[#1767A4] font-semibold text-lg mb-4 font-['Poppins']">Distribution des matières</h3>
            <p class="text-xs text-slate-500 mb-3">Matières avec le plus grand nombre de notes créées</p>
            <div class="flex">
                <div class="w-1/2">
                    @if(isset($matiereStats) && count($matiereStats) > 0)
                        @foreach($matiereStats as $index => $matiere)
                        <div class="mb-2 flex items-center">
                            <div class="w-3 h-3 rounded-full bg-[#{{ $matiere['color'] }}] mr-2"></div>
                            <span class="text-sm text-slate-700">{{ $matiere['nom'] }} ({{ $matiere['pourcentage'] }}%)</span>
                        </div>
                        @endforeach
                    @else
                        <div class="mb-2 flex items-center">
                            <span class="text-sm text-slate-500">Aucune donnée disponible</span>
                        </div>
                    @endif
                </div>
                <div class="w-1/2 flex items-center justify-center">
                    <!-- Graphique en donut stylisé -->
                    <div class="relative w-32 h-32">
                        <svg viewBox="0 0 36 36" class="w-full h-full">
                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="#F8FAFC" stroke-width="3"></circle>
                            @if(isset($matiereStats) && count($matiereStats) > 0)
                                @php
                                    $offset = 0;
                                @endphp
                                @foreach($matiereStats as $matiere)
                                    <circle cx="18" cy="18" r="15.915" fill="none" stroke="#{{ $matiere['color'] }}" stroke-width="3" 
                                        stroke-dasharray="{{ $matiere['pourcentage'] }} {{ 100 - $matiere['pourcentage'] }}" 
                                        stroke-dashoffset="-{{ $offset }}"></circle>
                                    @php
                                        $offset += $matiere['pourcentage'];
                                    @endphp
                                @endforeach
                            @endif
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-3 gap-6 mt-6">
        <!-- Alertes système -->
        <div class="relative bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
            <div class="bg-[#1767A4] py-4 px-6">
                <h3 class="text-white font-semibold text-lg font-['Poppins']">Alertes système</h3>
            </div>
            <div class="p-6">
                <div class="border-b border-slate-200 py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-red-500 mr-4"></div>
                        <span class="text-slate-700 font-medium">Pic d'utilisation API - 15:30</span>
                    </div>
                    <span class="text-xs text-slate-400">Il y a 35 min</span>
                </div>
                <div class="border-b border-slate-200 py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-orange-300 mr-4"></div>
                        <span class="text-slate-700 font-medium">Latence base de données - 14:45</span>
                    </div>
                    <span class="text-xs text-slate-400">Il y a 1h20</span>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-emerald-500 mr-4"></div>
                        <span class="text-slate-700 font-medium">Mise à jour modèle IA réussie</span>
                    </div>
                    <span class="text-xs text-slate-400">Il y a 3h</span>
                </div>
            </div>
        </div>
        
        <!-- Utilisateurs récents -->
        <div class="col-span-2 relative bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
            <div class="bg-[#1767A4] py-4 px-6">
                <h3 class="text-white font-semibold text-lg font-['Poppins']">Nouveaux utilisateurs</h3>
            </div>
            <div class="p-4">
                <div class="bg-slate-50 py-2 px-4 rounded mb-2">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-3">
                            <span class="text-xs font-semibold text-slate-500">NOM</span>
                        </div>
                        <div class="col-span-4">
                            <span class="text-xs font-semibold text-slate-500">EMAIL</span>
                        </div>
                        <div class="col-span-3">
                            <span class="text-xs font-semibold text-slate-500">INSCRIT LE</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-xs font-semibold text-slate-500">TYPE</span>
                        </div>
                    </div>
                </div>
                
                @if(isset($recentUsers) && count($recentUsers) > 0)
                    @foreach($recentUsers as $user)
                    <div class="border-b border-slate-200 py-3">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-3">
                                <span class="text-slate-700">{{ $user->name }}</span>
                            </div>
                            <div class="col-span-4">
                                <span class="text-slate-700">{{ $user->email }}</span>
                            </div>
                            <div class="col-span-3">
                                <span class="text-slate-700">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="px-3 py-1 rounded-full text-xs {{ $user->role == 'administrateur' ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">
                                    {{ $user->role == 'administrateur' ? 'Admin' : 'Étudiant' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="py-3 text-center">
                        <span class="text-slate-500">Aucun utilisateur récent</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
{{-- </div>

<script>
// Script pour les graphiques interactifs pourrait être ajouté ici
// Pour une implémentation complète, on pourrait utiliser Chart.js ou d3.js
</script>
</body>
</html> --}}
