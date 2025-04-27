<div class="sidebar">
    <div class="logo">
        <h2>LearningAid</h2>
    </div>
    <nav>
        <ul>
            <li class="{{ request()->is('dashboard_user') ? 'active' : '' }}">
                <a href="{{ url('/dashboard_user') }}">Tableau de bord</a>
            </li>
            <li class="{{ request()->is('notes*') ? 'active' : '' }}">
                <a href="{{ route('notes.index') }}">Mes notes</a>
            </li>
            <li class="{{ request()->is('quiz*') ? 'active' : '' }}">
                <a href="#">Quiz</a>
            </li>
            <li class="{{ request()->is('flashcards*') ? 'active' : '' }}">
                <a href="#">Flashcards</a>
            </li>
            <li class="{{ request()->is('groupes*') ? 'active' : '' }}">
                <a href="#">Groupes d'étude</a>
            </li>
            <li class="{{ request()->is('messagerie*') ? 'active' : '' }}">
                <a href="#">Messagerie</a>
            </li>
            <li class="logout-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">Déconnexion</button>
                </form>
            </li>
        </ul>
    </nav>
</div>