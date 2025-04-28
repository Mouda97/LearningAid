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
    <h1 class="font-['Poppins'] text-xl font-medium text-slate-800">LearningAid</h1>
    
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
  <div class="flex flex-1">
            <!-- Menu latéral -->
            <aside class="hidden md:block w-60 bg-white border-r border-gray-200">
                <nav class="mt-6">
                    <a href="/dashboard_user" class="block pl-8 py-3 text-sm {{ request()->is('dashboard_user') ? 'bg-blue-50 font-semibold text-blue-700 relative before:absolute before:left-0 before:top-0 before:h-full before:w-1 before:bg-blue-700' : 'text-gray-700' }}">
                        Tableau de bord
                    </a>
                    <a href="{{ route('notes.index') }}" class="block pl-8 py-3 text-sm {{ request()->routeIs('notes.*') ? 'bg-blue-50 font-semibold text-blue-700 relative before:absolute before:left-0 before:top-0 before:h-full before:w-1 before:bg-blue-700' : 'text-gray-700' }}">
                        Mes notes
                    </a>
                    <a href="#" class="block pl-8 py-3 text-sm text-gray-700">Quiz</a>
                    <a href="#" class="block pl-8 py-3 text-sm text-gray-700">Flashcards</a>
                    <a href="#" class="block pl-8 py-3 text-sm text-gray-700">Groupes d'étude</a>
                    <a href="#" class="block pl-8 py-3 text-sm text-gray-700">Messagerie</a>
                </nav>
            </aside>
  <div>
    @yield('content')
  </div>
  <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
