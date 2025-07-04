<header class="app-header">
  {{-- <a class="app-header__logo" href="index.html">Simpel Okura</a> --}}
  <a class="app-header__logo d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
    <img src="{{ asset('pekanbaru.png') }}" alt="Logo Pekanbaru" style="height: 30px;">
    Simpel Okura
</a>

      <!-- Sidebar toggle button-->
      <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        {{-- <li class="app-search">
          <input class="app-search__input" type="search" placeholder="Search">
          <button class="app-search__button"><i class="bi bi-search"></i></button>
        </li> --}}
        <!--Notification Menu-->
        
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu"><i class="bi bi-person fs-4"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            
            <li>
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="bi bi-box-arrow-right me-2 fs-5 text-danger"></i> Logout
                </button>
                </form>
            </li>
          </ul>
        </li>
      </ul>
    </header>