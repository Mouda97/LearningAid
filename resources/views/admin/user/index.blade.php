@extends('admin/baseA')
@section('content')
<!-- Contenu principal -->
<main class="flex-1 p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#1767A4] font-['Poppins']">Gestion des utilisateurs</h1>
        <p class="text-sm text-slate-600 mt-2">Administration des comptes et des accès</p>
    </div>
    
    <!-- Section des filtres et recherche -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-4">
                <!-- Barre de recherche -->
                <div class="relative flex items-center">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un utilisateur..." 
                        class="h-8 pl-8 pr-4 rounded-l text-sm bg-white border border-slate-200 w-64">
                    <div class="absolute left-3 pointer-events-none">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" class="text-slate-400">
                            <path d="M13 13L9 9M10.3333 5.66667C10.3333 8.244 8.244 10.3333 5.66667 10.3333C3.08934 10.3333 1 8.244 1 5.66667C1 3.08934 3.08934 1 5.66667 1C8.244 1 10.3333 3.08934 10.3333 5.66667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <button type="submit" class="h-8 px-3 bg-[#1767A4] text-white text-sm rounded-r">
                        Rechercher
                    </button>
                </div>
                
                <!-- Filtres -->
                <div class="relative">
                    <select name="role" class="h-8 px-4 pr-8 rounded text-sm bg-white border border-slate-200 appearance-none" onchange="this.form.submit()">
                        <option value="">Type</option>
                        <option value="etudiant" {{ request('role') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                        <option value="administrateur" {{ request('role') == 'administrateur' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" class="text-slate-600">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                
                <div class="relative">
                    <select name="status" class="h-8 px-4 pr-8 rounded text-sm bg-white border border-slate-200 appearance-none" onchange="this.form.submit()">
                        <option value="">Statut</option>
                        <option value="Actif" {{ request('status') == 'Actif' ? 'selected' : '' }}>Actif</option>
                        <option value="Inactif" {{ request('status') == 'Inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" class="text-slate-600">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                
                <div class="relative">
                    <select name="date" class="h-8 px-4 pr-8 rounded text-sm bg-white border border-slate-200 appearance-none" onchange="this.form.submit()">
                        <option value="">Date</option>
                        <option value="Plus récente" {{ request('date') == 'Plus récente' ? 'selected' : '' }}>Plus récente</option>
                        <option value="Plus ancienne" {{ request('date') == 'Plus ancienne' ? 'selected' : '' }}>Plus ancienne</option>
                    </select>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" class="text-slate-600">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Bouton de réinitialisation des filtres -->
                @if(request('search') || request('role') || request('status') || request('date'))
                <a href="{{ route('admin.users.index') }}" class="h-8 px-3 flex items-center text-sm text-slate-600 hover:text-slate-800">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" class="mr-1">
                        <path d="M1 1L13 13M1 13L13 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Réinitialiser
                </a>
                @endif
            </form>
        </div>
        
        <a href="{{ route('admin.users.create') }}" class="h-8 px-4 bg-[#1767A4] text-white text-sm font-medium rounded flex items-center">
            + Ajouter un utilisateur
        </a>
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
                    <div class="text-sm font-medium text-[#1767A4]">{{ $user->name }}</div>
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
            <div class="col-span-3 text-sm text-slate-600">
                {{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->format('d/m/Y - H:i') : 'Jamais connecté' }}
            </div>
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