@extends('admin.baseA')
@section('content')
<!-- Contenu principal -->
<main class="flex-1 p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#1767A4] font-['Poppins']">Modifier l'utilisateur</h1>
        <p class="text-sm text-slate-600 mt-2">Modification des informations du compte</p>
    </div>
    
    <div class="bg-white border border-slate-200 rounded-lg p-6">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Affichage des erreurs -->
            @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="list-disc pl-4 text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <div class="grid grid-cols-2 gap-6">
                <!-- Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nom complet</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                        class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Adresse email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                        class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Rôle -->
                <div>
                    <label for="role" class="block text-sm font-medium text-slate-700 mb-2">Type d'utilisateur</label>
                    <select name="role" id="role" 
                        class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="etudiant" {{ old('role', $user->role) == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                        <option value="administrateur" {{ old('role', $user->role) == 'administrateur' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                </div>
                
                <!-- Statut -->
                <div>
                    <label for="is_active" class="block text-sm font-medium text-slate-700 mb-2">Statut</label>
                    <select name="is_active" id="is_active" 
                        class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Actif</option>
                        <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                
                <!-- Mot de passe (optionnel) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                        Nouveau mot de passe <span class="text-xs text-slate-500">(laisser vide pour conserver l'actuel)</span>
                    </label>
                    <input type="password" name="password" id="password" 
                        class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Confirmation mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('admin.users.index') }}" 
                    class="px-4 py-2 bg-slate-100 text-[#FF5714] rounded-md hover:bg-slate-200">
                    Annuler
                </a>
                <button type="submit" 
                    class="px-4 py-2 bg-[#1767A4] text-white rounded-md hover:bg-[#FF5714]">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</main>
@endsection