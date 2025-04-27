<header class="dashboard-header">
    <div class="search-bar">
        <form action="#" method="GET">
            <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="user-profile">
        <div class="notifications">
            <i class="far fa-clock"></i>
        </div>
        <div class="profile-info">
            <span class="profile-initials">{{ Auth::user()->name[0] ?? 'U' }}</span>
        </div>
    </div>
</header>