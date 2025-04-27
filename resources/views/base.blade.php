<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearningAid</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body>
<header class="bg-white py-4 px-25  shadow-md">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <img src="{{ asset("assets/img/logo manuella.png")}}" class="h-15" alt="Logo" >
        <nav class="space-x-4">
            <a href="#" class="text-[#1767A4] font-bold text-md hover:text-[#FF5714]">Accueil</a>
            <a href="#" class="text-[#1767A4] font-bold text-md hover:text-[#FF5714]">A propos</a>
            <a href="#" class="text-[#1767A4] font-bold text-md hover:text-[#FF5714]">Contact</a>
        </nav>
        <div>
            <a href="{{ route('register')}}" class="text-[#1767A4] font-bold rounded-full py-1 px-3 hover:border hover:border-xl hover:boder-[#1767A4] mr-4">Inscription</a>
            <a href="{{ route('login')}}" class="bg-[#FF5714] font-bold text-white py-1 px-4 rounded-full  hover:bg-[#1767A4] focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">Connexion</a>
        </div>
    </div>
</header>
<div>
    @yield('content')
</div>
<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-30">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-20">
            <div>
                <img src="{{ asset("assets/img/logo manuella footer.png")}}" alt="Logo" >
                <p class="mt-2 text-gray-400">Transformez votre façon d'apprendre avec l'IA. </p>
            </div>
            <div>
                <h3 class="font-semibold mb-4">Produit</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Fonctionnalités</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Tarifs</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Témoignages</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-4">Entreprise</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('welcome')}}" class="text-gray-400 hover:text-white">Acceuil</a></li>
                    {{-- <li><a href="{{ route('apropos')}}" class="text-gray-400 hover:text-white">À propos</a></li>
                    <li><a href="{{ route('contact')}}" class="text-gray-400 hover:text-white">Contact</a></li> --}}
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-4">Légal</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Conditions</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Confidentialité</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t text-center border-gray-700 mt-8 pt-8 text-sm text-gray-400">
            <p>© 2023 LearningAid. Tous droits réservés.</p>
        </div>
    </div>
</footer>
</body>
</html>
