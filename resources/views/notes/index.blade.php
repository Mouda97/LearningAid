@extends('etudiant.baseE')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Notes</h1>
        <div class="space-x-2">
            <a href="{{ route('notes.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition">
                <i class="fas fa-plus mr-2"></i>Nouvelle Note
            </a>
            <a href="{{ route('notesy') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition">
                <i class="fas fa-file-import mr-2"></i>Importer
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if($notes->isEmpty())
    <div class="bg-gray-100 rounded-lg p-8 text-center">
        <p class="text-gray-600 text-lg">Vous n'avez pas encore de notes. Commencez par en créer une !</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($notes as $note)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden border border-gray-200">
            <div class="p-5">
                <h2 class="text-xl font-semibold text-gray-800 mb-2 truncate">{{ $note->title }}</h2>
                <p class="text-gray-600 mb-4 h-12 overflow-hidden">{{ Str::limit(strip_tags($note->content), 100) }}</p>
                <div class="flex justify-between items-center text-sm text-gray-500">
                    {{-- <span>{{ $note->created_at->format('d/m/Y') }}</span> --}}
                    <span class="px-2 py-1 rounded-full text-xs {{ $note->statut == 'publiee' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($note->statut) }}
                    </span>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3 flex justify-between border-t">
                <a href="{{ route('notes.show', $note) }}" class="text-blue-500 hover:text-blue-700">
                    <i class="fas fa-eye mr-1"></i>Voir
                </a>
                <a href="{{ route('notes.edit', $note) }}" class="text-yellow-500 hover:text-yellow-700">
                    <i class="fas fa-edit mr-1"></i>Modifier
                </a>
                <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-trash mr-1"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $notes->links() }}
    </div>
    @endif
</div>
@endsection