@extends('etudiant.baseE')
@section('content')
<!DOCTYPE html>
   <html lang="fr">

   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Quiz</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   </head>

   <body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-4">
     <h1 class="text-2xl font-semibold mb-4">Créer un Quiz</h1>

     <div class="bg-white shadow rounded-md p-4 mb-4">
      <form action="{{ route('quizzes.store') }}" method="POST">
       @csrf

       <div class="mb-4">
        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}"
         class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
         required>
        @error('titre')
         <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
       </div>

       <div class="mb-4">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
        <textarea id="description" name="description" rows="3"
         class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
        @error('description')
         <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
       </div>

       <div class="mb-4">
        <label for="note_id" class="block text-gray-700 text-sm font-bold mb-2">Notes (Optionnel)</label>
        <select id="note_id" name="note_id"
         class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
         <option value="">Aucune</option>
         @foreach (\App\Models\Note::all() as $note)
          <option value="{{ $note->id }}" {{ old('note_id') == $note->id ? 'selected' : '' }}>
           {{ $note->nom }}</option>
         @endforeach
        </select>
        @error('note_id')
         <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
       </div>

       <div class="mb-4">
        <label for="nombre_questions" class="block text-gray-700 text-sm font-bold mb-2">Nombre de Questions</label>
        <input type="number" id="nombre_questions" name="nombre_questions" value="{{ old('nombre_questions', 0) }}"
         class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
         required>
        @error('nombre_questions')
         <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
       </div>

       <div class="mb-4">
        <label for="temps_limite" class="block text-gray-700 text-sm font-bold mb-2">Temps Limite (minutes)</label>
        <input type="number" id="temps_limite" name="temps_limite" value="{{ old('temps_limite') }}"
         class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        @error('temps_limite')
         <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
       </div>

       <div class="mb-4">
        <label for="statut" class="block text-gray-700 text-sm font-bold mb-2">Statut</label>
        <select id="statut" name="statut"
         class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
         required>
         <option value="brouillon" {{ old('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
         <option value="publié" {{ old('statut') == 'publié' ? 'selected' : '' }}>Publié</option>
         <option value="archivé" {{ old('statut') == 'archivé' ? 'selected' : '' }}>Archivé</option>
        </select>
        @error('statut')
         <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
       </div>

       <div class="flex items-center justify-between">
        <button
         class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
         type="submit">
         Créer
        </button>
        <a href="{{ route('quizzes.index') }}"
         class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
         Annuler
        </a>
       </div>
      </form>
     </div>
    </div>
   </body>

   </html>
   @endsection