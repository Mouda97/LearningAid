@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    {{-- Entête avec Titre et boutons Modifier/Supprimer --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $note->titre }}</h1>
            <p class="text-gray-600">Créée le {{ $note->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('notes.edit', $note) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                <i class="fas fa-edit mr-1"></i>Modifier
            </a>
            <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    <i class="fas fa-trash mr-1"></i>Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Affichage du Contenu de la Note --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="prose max-w-none">
                {{-- Utilise nl2br pour les sauts de ligne et e() pour échapper le HTML --}}
                {!! nl2br(e($note->contenu)) !!}
            </div>
        </div>

        {{-- Affichage des Métadonnées --}}
        <div class="bg-gray-50 p-6 border-t">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Statut</h3>
                    <p class="mt-1">
                        <span class="px-2 py-1 rounded-full text-xs {{ $note->statut == 'publiee' ? 'bg-green-100 text-green-800' : ($note->statut == 'archivee' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($note->statut) }}
                        </span>
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Visibilité</h3>
                    <p class="mt-1">{{ ucfirst($note->niveau_visibilite) }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Catégorie</h3>
                    <p class="mt-1">{{ $note->categorie ?: 'Non spécifiée' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Matière</h3>
                    <p class="mt-1">{{ $note->matiere ?: 'Non spécifiée' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Chapitre</h3>
                    <p class="mt-1">{{ $note->chapitre ?: 'Non spécifié' }}</p>
                </div>
                @if($note->tags)
                <div class="col-span-2 md:col-span-3">
                    <h3 class="text-sm font-medium text-gray-500">Tags</h3>
                    <div class="mt-1 flex flex-wrap gap-2">
                        @foreach(explode(',', $note->tags) as $tag)
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- == SECTION AJOUTÉE POUR LES ACTIONS IA == --}}
    {{-- =============================================== --}}
    <div class="mt-6 bg-white rounded-lg shadow-md p-6 border border-indigo-100">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">
            <i class="fas fa-robot mr-2 text-indigo-500"></i>Actions IA
        </h3>
        <p class="text-sm text-gray-600 mb-4">Utilisez l'IA pour générer automatiquement du contenu d'étude à partir de cette note.</p>

        {{-- Affichage des messages de statut/erreur --}}
        @if(session('status'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded" role="alert">
                <p>{{ session('status') }}</p>
            </div>
        @endif
         @if(session('error'))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        {{-- Boutons/Formulaires pour l'IA --}}
        <div class="flex flex-wrap gap-3">
            {{-- Formulaire pour Générer Quiz --}}
            <form action="{{ route('notes.ai.generate.quiz', $note) }}" method="POST" onsubmit="this.querySelector('button').disabled=true; this.querySelector('button').innerHTML='<i class=\'fas fa-spinner fa-spin mr-2\'></i>Génération...';">
                @csrf
                <div class="mb-3">
                    <label for="num_questions" class="block text-sm font-medium text-gray-700 mb-1">Nombre de questions</label>
                    <select id="num_questions" name="num_questions" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        @for ($i = 1; $i <= 30; $i++)
                            <option value="{{ $i }}" {{ $i == 3 ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Générer Quiz IA
                </button>
            </form>

            {{-- Formulaire pour Générer Flashcards --}}
            <form action="{{ route('notes.ai.generate.flashcards', $note) }}" method="POST" onsubmit="this.querySelector('button').disabled=true; this.querySelector('button').innerHTML='<i class=\'fas fa-spinner fa-spin mr-2\'></i>Génération...';">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 active:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Générer Flashcards IA
                </button>
            </form>
        </div>
    </div>
    {{-- =============================================== --}}
    {{-- == FIN SECTION AJOUTÉE POUR LES ACTIONS IA == --}}
    {{-- =============================================== --}}

    {{-- Lien Retour --}}
    <div class="mt-6">
        <a href="{{ route('notes.index') }}" class="text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-1"></i>Retour à la liste
        </a>
    </div>

    <!-- Ajoutez ce formulaire là où vous avez le bouton pour générer le quiz -->
    <form action="{{ route('notes.ai.generate.quiz', $note) }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="num_questions" class="block text-sm font-medium text-gray-700 mb-1">Nombre de questions</label>
            <select id="num_questions" name="num_questions" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                @for ($i = 1; $i <= 30; $i++)
                    <option value="{{ $i }}" {{ $i == 3 ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Générer Quiz IA
        </button>
    </form>
</div>
@endsection