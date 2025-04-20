<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden md:max-w-2xl lg:max-w-3xl">
        <div class="flex flex-col md:flex-row">
            <div class="bg-[#3E81B3] text-white p-8 md:w-1/2 flex flex-col justify-center items-start">
                <h2 class="text-3xl font-bold mb-4">Bienvenue</h2>
                <p class="text-lg">Débloque ton succès universitaire : les cours dont tu as besoin, quand tu en as besoin.</p>
            </div>
            <div class="bg-black text-white p-8 md:w-1/2">
                <h2 class="text-2xl font-semibold mb-6">S'inscrire</h2>

                @if (session('success'))
                <div class="bg-green-200 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Succès!</strong><br>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif
                <form class="space-y-4" action="{{route('register')}}" method="POST">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium">Nom</label>
                        <input type="text" id="name" name="name" class="mt-1 block w-full text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('name')
                         <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input type="email" id="email" name="email" class="mt-1 block w-full text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('email')
                         <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium">Mot de passe</label>
                        <input type="password" id="password" name="password" class="mt-1 block w-full text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('password')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium">Confirmer mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('password_confirmation')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                            Enregistrer
                        </button>
                    </div>
                </form>
                <p class="mt-4 text-sm text-gray-400">Avez-vous déjà un compte ? <a href="{{ route('login')}}" class="text-blue-400 hover:underline">Se connecter</a></p>
            </div>
        </div>
    </div>
</body>
</html>