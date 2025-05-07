@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    {{-- Entête avec Titre et boutons Modifier/Supprimer --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1767A4]">{{ $note->title }}</h1>
            <p class="text-gray-600">Créée le {{ $note->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <div class="flex space-x-3 ml-auto pr-2">
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
    <div class="bg-white rounded-lg shadow-md overflow-hidden w-full">
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
                    <h3 class="text-sm font-medium text-[#1767A4]">Statut</h3>
                    <p class="mt-1">
                        <span class="px-2 py-1 rounded-full text-xs {{ $note->statut == 'publiee' ? 'bg-green-100 text-green-800' : ($note->statut == 'archivee' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($note->statut) }}
                        </span>
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-[#1767A4]">Visibilité</h3>
                    <p class="mt-1">{{ ucfirst($note->niveau_visibilite) }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-[#1767A4]">Catégorie</h3>
                    <p class="mt-1">{{ $note->categorie ?: 'Non spécifiée' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-[#1767A4]">Matière</h3>
                    <p class="mt-1">{{ $note->matiere ?: 'Non spécifiée' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-[#1767A4]">Chapitre</h3>
                    <p class="mt-1">{{ $note->chapitre ?: 'Non spécifié' }}</p>
                </div>
                @if($note->tags)
                <div class="col-span-2 md:col-span-3">
                    <h3 class="text-sm font-medium text-[#1767A4]">Tags</h3>
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
    <div class="mt-6 bg-white rounded-lg shadow-md p-6 border border-indigo-100 w-full">
        <h3 class="text-lg font-semibold text-[#1767A4] mb-3">
            <i class="fas fa-robot mr-2 text-[#1767A4]"></i>Actions IA
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
        <div class="flex flex-wrap gap-6 w-full">
            {{-- Formulaire pour Générer Quiz --}}
            <div class="p-4 bg-white rounded-lg shadow flex-1">
                <h3 class="text-lg font-semibold mb-2 text-[#1767A4]">Générer un Quiz avec l'IA</h3>
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
                    
                    <div class="mb-3">
                        <label for="question_type" class="block text-sm font-medium text-gray-700 mb-1">Type de questions</label>
                        <select id="question_type" name="question_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="choix_multiple">Choix multiple</option>
                            <option value="vrai_faux">Vrai ou Faux</option>
                            <option value="reponse_court">Réponse courte</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Générer Quiz IA
                    </button>
                </form>
            </div>

            {{-- Formulaire pour Générer Flashcards --}}
            <div class="p-4 bg-white rounded-lg shadow flex-1">
                <h3 class="text-lg font-semibold mb-2 text-[#1767A4]">Générer des Flashcards avec l'IA</h3>
                <form action="{{ route('notes.ai.generate.flashcards', $note) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="num_flashcards" class="block text-sm font-medium text-gray-700 mb-1">Nombre de flashcards</label>
                        <select id="num_flashcards" name="num_flashcards" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            @for ($i = 1; $i <= 20; $i++)
                                <option value="{{ $i }}" {{ $i == 5 ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Générer Flashcards IA
                    </button>
                </form>
            </div>
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

    {{-- Suppression du formulaire dupliqué --}}
</div>
@endsection