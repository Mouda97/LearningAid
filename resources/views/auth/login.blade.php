<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se Connecter</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">
    
    <div class="bg-black rounded-lg shadow-xl overflow-hidden flex md:max-w-2xl">
        <div class="bg-[#3E81B3] text-white p-8 md:w-1/2 flex flex-col justify-center items-start">
            <h2 class="text-3xl font-bold mb-4">Bienvenue</h2>
            <p class="text-lg">Débloque ton succès universitaire : les cours dont tu as besoin, quand tu en as besoin.</p>
        </div>
        <div class="bg-black text-white p-8 md:w-1/2">
            <h2 class="text-2xl font-semibold mb-6">Se Connecter</h2>
            {{-- @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    @if (session('success'))
        <div class="bg-green-200 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Succès!</strong><br>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <form class="space-y-4" action="{{route('login')}}" method="POST">
        @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full text-black rounded-md border-gray-700 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                    @error('email')
                         <p class="text-red-500 text-xs italic">{{ $message }}</p>
                     @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Mot de passe</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full text-black rounded-md border-gray-700 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                    @error('password')
                         <p class="text-red-500 text-xs italic">{{ $message }}</p>
                     @enderror
                </div>
                <div>
                    <button type="submit" class="w-full bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                        Envoyer
                    </button>
                </div>
            </form>
            <p class="mt-4 text-sm text-gray-400">Voulez-vous créer un compte ? <a href="{{ route('register')}}" class="text-blue-400 hover:underline">S'inscrire</a></p>
        </div>
    </div>
</body>
</html>
