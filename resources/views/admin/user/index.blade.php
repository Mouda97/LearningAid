@extends('admin/baseA')
@section('content')
<!-- Contenu principal -->
<main class="flex-1 p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-blue-700 font-['Poppins']">Gestion des utilisateurs</h1>
        <p class="text-sm text-slate-600 mt-2">Administration des comptes et des accès</p>
    </div>
    
    <!-- Section filtre et recherche -->
    <div class="flex items-center justify-between p-4 bg-white border border-slate-200 rounded-lg mb-4">
        <div class="flex items-center gap-4">
            <div class="relative">
                <input 
                    type="text" 
                    placeholder="Rechercher un utilisateur..." 
                    class="w-[300px] h-8 px-8 py-2 rounded text-sm bg-slate-100 border border-slate-200"
                >
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                    <svg width="12" height="12" viewBox="0 0 12 12" class="text-slate-400">
                        <circle cx="5" cy="5" r="4" fill="none" stroke="currentColor" stroke-width="1.5"></circle>
                        <path d="M8 8 L10 10" stroke="currentColor" stroke-width="1.5"></path>
                    </svg>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative">
                    <select class="h-8 px-4 pr-8 rounded text-sm bg-white border border-slate-200 appearance-none">
                        <option>Type</option>
                        <option>Prof</option>
                        <option>Élève</option>
                        <option>École</option>
                    </select>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" class="text-slate-600">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                
                <div class="relative">
                    <select class="h-8 px-4 pr-8 rounded text-sm bg-white border border-slate-200 appearance-none">
                        <option>Statut</option>
                        <option>Actif</option>
                        <option>Inactif</option>
                        <option>En attente</option>
                    </select>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" class="text-slate-600">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                
                <div class="relative">
                    <select class="h-8 px-4 pr-8 rounded text-sm bg-white border border-slate-200 appearance-none">
                        <option>Date</option>
                        <option>Plus récente</option>
                        <option>Plus ancienne</option>
                    </select>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" class="text-slate-600">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <button class="h-8 px-4 bg-blue-700 text-white text-sm font-medium rounded">
            + Ajouter un utilisateur
        </button>
    </div>
    
    <!-- Section liste des utilisateurs -->
    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
        <!-- En-tête du tableau -->
        <div class="grid grid-cols-12 gap-4 px-4 py-4 bg-slate-50 text-sm font-semibold text-slate-500">
            <div class="col-span-2">NOM</div>
            <div class="col-span-3">EMAIL</div>
            <div class="col-span-1">TYPE</div>
            <div class="col-span-1">STATUT</div>
            <div class="col-span-3">DERNIÈRE CONNEXION</div>
            <div class="col-span-2 text-right">ACTIONS</div>
        </div>
        
        <!-- Lignes utilisateurs -->
        @forelse($users as $user)
        <div class="border-t border-slate-200 py-4 px-4 grid grid-cols-12 gap-4 items-center">
            <div class="col-span-2 flex items-center">
                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-xs text-slate-600 mr-3">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <div class="text-sm font-medium text-blue-700">{{ $user->name }}</div>
                    <div class="text-xs text-slate-500">{{ $user->profile ?? 'Utilisateur' }}</div>
                </div>
            </div>
            <div class="col-span-3 text-sm text-slate-600">{{ $user->email }}</div>
            <div class="col-span-1">
                <span class="px-3 py-1 {{ $user->role == 'administrateur' ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }} text-xs rounded-full">
                    {{ $user->role == 'administrateur' ? 'Admin' : 'Étudiant' }}
                </span>
            </div>
            <div class="col-span-1">
                <span class="px-3 py-1 {{ $user->is_active ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} text-xs rounded-full">
                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                </span>
            </div>
            <div class="col-span-3 text-sm text-slate-600">{{ $user->last_login ? $user->last_login->format('d/m/Y - H:i') : 'Jamais connecté' }}</div>
            <div class="col-span-2 flex justify-end gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="w-8 h-8 rounded bg-slate-100 flex items-center justify-center">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" class="text-slate-500">
                        <path d="M4 8H12 M8 4V12" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded bg-slate-100 flex items-center justify-center" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" class="text-slate-500">
                            <path d="M4 8H12" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="border-t border-slate-200 py-8 px-4 text-center">
            <p class="text-slate-500">Aucun utilisateur trouvé</p>
        </div>
        @endforelse
        
        <!-- Pagination -->
        <div class="border-t border-slate-200 p-4 bg-slate-50 flex items-center justify-between">
            <div class="text-sm text-slate-600">
                Affichage de {{ $users->firstItem() ?? 0 }} à {{ $users->lastItem() ?? 0 }} sur {{ $users->total() ?? 0 }} utilisateurs
            </div>
            
            <div class="flex items-center gap-2">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</main>
@endsection