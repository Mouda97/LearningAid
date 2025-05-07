<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LearningAid - Paramètres</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
  <!-- En-tête -->
  <header class="h-16 w-full bg-white border-b border-slate-200 flex items-center justify-between px-6">
    <div class="flex items-center">
        <h1 class="text-[#1767A4] font-bold text-2xl font-['Poppins']">LearningAid</h1>
        <span class="text-[#FF5714] font-medium text-base ml-4 font-['Poppins']">Admin</span>
    </div>
    
    <!-- Barre de recherche -->
    <div class="relative ml-16">
      <input type="text" placeholder="Rechercher..." class="w-96 h-8 bg-slate-100 border border-slate-200 rounded-md pl-10 text-sm text-slate-400">
      <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
    </div>
    
    <!-- Icônes dans l'en-tête -->
    <div class="flex items-center space-x-4">
      <div class="h-8 w-8 bg-slate-100 rounded-full flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
      </div>
      <div class="h-8 w-8 bg-slate-100 rounded-full flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
      </div>
        <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName" class="flex items-center text-sm pe-1 font-medium text-gray-500 rounded-lg hover:text-blue-600 dark:hover:text-blue-500 md:me-0    dark:text-gray-900" type="button">
          {{-- <img src="{{ asset('assets/img/shopping-cart.png') }}" class="me-4" alt="panier"> --}}
          <Span class="text-lg me-3 text-[#176abc]">{{ Auth::user()->name }}</Span>
          
          @if (Auth::user()->profile_photo)
          <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" alt="user photo" class="rounded-full w-12 h-12" >
          @else
              <img class="img-profile rounded-circle w-12 h-12" alt="user photo"  src="{{asset('assets/img/iconPersonne.png')}}">
          @endif
         </button>
  
        <!-- Dropdown menu -->
        <div id="dropdownAvatarName" class="z-10 hidden bg-gray-800 divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-white dark:divide-[#44C244]">
            <div class="px-4 py-3 text-sm text-white dark:text-gray-900">
                {{-- <div class="font-bold ">{{ Auth::user()->name }}</div> --}}
                {{-- <div class="truncate">{{ Auth::user()->telephone }}</div> --}}
            </div>
            <ul class="py-2 text-md text-white  dark:text-[#176abc]" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                <li>
                    <a href="#" class="block font-bold text-md px-4 py-2  hover:bg-[#176abc] dark:hover:bg-[#176abc] dark:hover:text-white">Profil</a>
                </li>
                {{-- <li>
                    <a href="#" class="block font-bold text-md px-4 py-2  hover:bg-[#176abc] dark:hover:bg-[#176abc] dark:hover:text-white">carte</a>
                </li> --}}
            </ul>
            
                
                <form method="POST" action="{{ route('logout') }}">
                    <div class="py-2">
                        @csrf
                    <button type="submit" class="block font-bold px-7 py-2 text-md text-white hover:bg-gray-100 dark:hover:bg-[red] dark:text-[red] dark:hover:text-white">Se deconnecter</button>
                    </div>
                </form>
                
            
        </div>
      </div>
  </header>

  <div class="flex">
    <!-- Menu latéral -->
    <aside class="w-60 bg-white h-screen border-r border-slate-200">
        <nav class="py-6">
            <ul>
                <li class="relative">
                    <a href="{{route('admin.dashboard')}}" class="flex items-center px-6 py-2 bg-blue-50 text-[#1767A4] font-semibold">
                        <div class="absolute left-0 top-0 h-full w-1 bg-[#1767A4]"></div>
                        <svg class="mr-4 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Tableau de bord
                    </a>
                </li>
                <li>
                    <a href="{{route('gestion.index')}}" class="flex items-center px-6 py-2 text-slate-700">
                        <svg class="mr-4 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Gestion des utilisateurs
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-6 py-2 text-slate-700">
                        <svg class="mr-4 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        Modèles IA
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-6 py-2 text-slate-700">
                        <svg class="mr-4 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Contenu éducatif
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-6 py-2 text-slate-700">
                        <svg class="mr-4 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Rapports analytiques
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-6 py-2 text-slate-700">
                        <svg class="mr-4 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Paramètres système
                    </a>
                </li>
            </ul>
            
            <div class="mt-6 border-t border-slate-200 mx-6 pt-6">
                <h3 class="text-xs font-semibold text-slate-400 uppercase px-3 mb-3">ACCÈS UTILISATEUR</h3>
                <ul>
                    <li>
                        <a href="#" class="flex items-center px-6 py-2 text-slate-700">
                            <svg class="mr-4 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Vue utilisateur
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-6 py-2 text-slate-700">
                            <svg class="mr-4 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Support utilisateurs
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>
    <div>
        @yield('content')
      </div>
      <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
    