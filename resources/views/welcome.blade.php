@extends('base')
@section('content')
<main>
    <section class="bg-[#E8F0F6] py-16">
        <div class="container mx-auto px-30 md:flex md:items-center md:justify-between">
            <div class="md:w-1/2 lg:w-7/12 mb-4">
                <h1 class="text-5xl mb-2 text-center font-bold text-gray-800">Boostez votre apprentissage avec l'IA</h1>
                <p class="text-gray-700 text-lg      text-center mb-6">Transformez vos notes en cartes flash, créez des quiz et apprenez efficacement en un clic.</p>
                <div class="flex justify-center space-x-4">
                    <button class="bg-[#FF5714] text-lg text-white py-1 px-2 rounded-xl font-bold hover:bg-[#1767A4] focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">Créer un compte</button>
                    <button class="text-white font-bold border bg-[#1767A4] py-1 px-2 rounded-xl hover:bg-[#FF5714] focus:outline-none">Voir la démo</button>
                </div>
            </div>
            <div class="md:w-1/2 lg:w-5/12 mt-30 md:mt-0">
                <img src="{{ asset("assets/img/imageHero.png")}}" alt="Fille apprenant" class="h-90 w-auto ">
            </div>
        </div>
    </section>

    <section class="py-12 bg-white ">
        <div class="container mx-auto px-30 text-center">
            <h2 class="text-2xl font-bold text-[#1767A4] mb-8">Comment ça marche ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-2 bg-white rounded-lg shadow-md shadow-t-md shadow-gray-400">
                    <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset("assets/img/iconTelecherger.png")}}" alt="Importer vos notes">
                    </div>
                    <h3 class="font-semibold text-lg text-[#1767A4] mb-2">1. Importez vos notes</h3>
                    <p class="text-gray-600">avec votre fichier PDF</p>
                </div>
                <div class="p-2 bg-white rounded-lg shadow-md shadow-gray-400">
                    <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset("assets/img/iconIdee.png")}}" alt="L'IA analyse le contenu"  >
                    </div>
                    <h3 class="font-semibold text-lg text-[#1767A4] mb-2">2. L'IA analyse le contenu</h3>
                    <p class="text-gray-600">et extrait les informations clés</p>
                </div>
                <div class="p-2 bg-white rounded-lg shadow-md shadow-gray-400">
                    <div class="w-12 h-12  rounded-full flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset("assets/img/icinValider.png")}}" alt="Réviser efficacement" >
                    </div>
                    <h3 class="font-semibold text-lg text-[#1767A4] mb-2">3. Révisez efficacement</h3>
                    <p class="text-gray-600">avec des flashcards personnalisées</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités clés -->
    <section class="py-8">
        <div class="container mx-auto px-30">
            <h2 class="font-poppins text-3xl font-bold text-center text-[#1767A4] mb-12">Fonctionnalités clés</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Carte 1 -->
                <div class="bg-white p-6 rounded-xl  border border-gray-500 hover:border-primary transition feature-card">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 p-2 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-poppins text-xl font-semibold">Import de notes</h3>
                    </div>
                    <p class="text-gray-600">PDF, Word, OCR image. Centralisez toutes vos ressources.</p>
                </div>
                
                <!-- Carte 2 -->
                <div class="bg-white p-6 rounded-xl  border border-gray-500 hover:border-primary transition feature-card">
                    <div class="flex items-center mb-4">
                        <div class="bg-orange-100 p-2 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="font-poppins text-xl font-semibold">Quiz automatique</h3>
                    </div>
                    <p class="text-gray-600">Génération intelligente de questions à partir de vos notes.</p>
                </div>
                
                <!-- Carte 3 -->
                <div class="bg-white p-6 rounded-xl  border border-gray-500 hover:border-primary transition feature-card">
                    <div class="flex items-center mb-4">
                        <div class="bg-purple-100 p-2 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-poppins text-xl font-semibold">Flashcards SRS</h3>
                    </div>
                    <p class="text-gray-600">Répétition espacée pour une mémorisation optimale.</p>
                </div>
                
                <!-- Carte 4 -->
                <div class="bg-white p-6 rounded-xl  border border-gray-500 hover:border-primary transition feature-card">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-2 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-poppins text-xl font-semibold">Collaboration</h3>
                    </div>
                    <p class="text-gray-600">Travaillez en temps réel avec vos camarades.</p>
                </div>
                
                <!-- Carte 5 -->
                <div class="bg-white p-6 rounded-xl  border border-gray-500 hover:border-primary transition feature-card">
                    <div class="flex items-center mb-4">
                        <div class="bg-yellow-100 p-2 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-poppins text-xl font-semibold">Suivi des performances</h3>
                    </div>
                    <p class="text-gray-600">Analyses et suggestions pour progresser.</p>
                </div>
                
                <!-- Carte 6 -->
                <div class="bg-white p-6 rounded-xl  border border-gray-500 hover:border-primary transition feature-card">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-100 p-2 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                        </div>
                        <h3 class="font-poppins text-xl font-semibold">Cloud & Multiplateforme</h3>
                    </div>
                    <p class="text-gray-600">Accédez à vos contenus partout, sur tous vos appareils.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pourquoi LearningAid -->
    <section class="py-16 bg-[#1767A4] text-white">
        <div class="container mx-auto px-30">
            <h2 class="font-poppins text-3xl font-bold text-center mb-12">Pourquoi choisir LearningAid ?</h2>
            <div class="grid md:grid-cols-4 gap-6 text-center">
                <div class="p-4">
                    <svg class="w-10 h-10 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <h3 class="font-poppins text-xl font-semibold mb-2">Apprentissage intelligent</h3>
                    <p class="opacity-90">L'IA adapte le contenu à vos besoins</p>
                </div>
                <div class="p-4">
                    <svg class="w-10 h-10 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="font-poppins text-xl font-semibold mb-2">Gain de temps</h3>
                    <p class="opacity-90">Générez des supports en quelques secondes</p>
                </div>
                <div class="p-4">
                    <svg class="w-10 h-10 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <h3 class="font-poppins text-xl font-semibold mb-2">Personnalisation</h3>
                    <p class="opacity-90">Adapté à votre style d'apprentissage</p>
                </div>
                <div class="p-4">
                    <svg class="w-10 h-10 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    <h3 class="font-poppins text-xl font-semibold mb-2">Multiplateforme</h3>
                    <p class="opacity-90">Disponible sur tous vos appareils</p>
                </div>
            </div>
        </div>
    </section>

     <!-- FAQ -->
     <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 max-w-3xl">
            <h2 class="font-poppins text-3xl font-bold text-center text-dark mb-12">Questions fréquentes</h2>
            
            <div class="space-y-4">
                <!-- Question 1 -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <button class="flex justify-between items-center w-full text-left">
                        <h3 class="font-poppins font-semibold text-lg">L'application est-elle gratuite ?</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="mt-3 text-gray-600">
                        <p>LearningAid propose une version gratuite avec des fonctionnalités de base. Des abonnements premium sont disponibles pour débloquer toutes les capacités de l'IA et des outils avancés.</p>
                    </div>
                </div>
                
                <!-- Question 2 -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <button class="flex justify-between items-center w-full text-left">
                        <h3 class="font-poppins font-semibold text-lg">Puis-je importer une image de notes manuscrites ?</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="mt-3 text-gray-600 hidden">
                        <p>Oui ! Notre technologie OCR (reconnaissance optique de caractères) permet de convertir vos notes manuscrites en texte éditable, à condition que l'écriture soit lisible.</p>
                    </div>
                </div>
                
                <!-- Question 3 -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <button class="flex justify-between items-center w-full text-left">
                        <h3 class="font-poppins font-semibold text-lg">Mes données sont-elles sécurisées ?</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="mt-3 text-gray-600 hidden">
                        <p>Absolument. Nous utilisons un chiffrement de bout en bout et ne partageons jamais vos données avec des tiers. Vous pouvez supprimer vos données à tout moment.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-orange-500">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-semibold text-white mb-4">Prêt à révolutionner votre apprentissage ?</h2>
            <p class="text-white mb-8">Inscrivez-vous gratuitement et commencez dès aujourd'hui.</p>
            <button class="bg-white text-orange-500 py-3 px-8 rounded-full font-semibold hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-orange-500">Commencer gratuitement</button>
        </div>
    </section>
</main>

</section>
</main>

<script src="{{ asset('assets/js/faq.js') }}"></script>

@endsection