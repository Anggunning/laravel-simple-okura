<aside class="app-sidebar">
       <div class="app-sidebar__user d-flex align-items-center">
    <i class="bi bi-person-circle fs-1 me-3 text-white"></i>
    <div>
          <p class="app-sidebar__user-name">{{ auth()->user()->username }}</p>
          <p class="app-sidebar__user-designation">{{ auth()->user()->role }}</p>
        </div>
      </div>
       <ul class="app-menu">
        <li>
            <a class="app-menu__item" href="{{ route('dashboard') }}">
                <i class="app-menu__icon bi bi-speedometer"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon bi bi-laptop"></i>
                <span class="app-menu__label">Pengajuan Surat</span>
                <i class="treeview-indicator bi bi-chevron-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="{{ route('sktm.index') }}">
                        <i class="icon bi bi-circle-fill"></i>SK Tidak Mampu</a>
                </li>
                <li>
                    <a class="treeview-item" href="{{ route('sku.index') }}" >
                        <i class="icon bi bi-circle-fill"></i>SK Usaha</a>
                </li>
                
                <li>
                    <a class="treeview-item" href="{{ route('skp.index') }}"><i class="icon bi bi-circle-fill">
                        </i>SK Perkawinan</a>
                </li>
            </ul>
        </li>
        @if (auth()->check())
            {{-- Penduduk Miskin --}}
            @if (!in_array(auth()->user()->role, ['Masyarakat', 'Lurah', 'Sekretaris']))
                <li>
                    <a class="app-menu__item" href="{{ route('pendudukMiskin.index') }}">
                        <i class="app-menu__icon bi bi-speedometer"></i>
                        <span class="app-menu__label">Penduduk Miskin</span>
                    </a>
                </li>
            @endif
       
        {{-- Peta Persebaran --}}
        @if (auth()->user()->role != 'Masyarakat')
            <li>
                <a class="app-menu__item" href="{{ route('pendudukMiskin.peta') }}">
                    <i class="app-menu__icon bi bi-code-square"></i>
                    <span class="app-menu__label">Peta Persebaran</span>
                </a>
            </li>
        @endif

        {{-- Data Pengguna --}}
        @if (auth()->user()->role === 'Admin')
            <li>
                <a class="app-menu__item" href="{{ route('dataPengguna.index') }}">
                    <i class="app-menu__icon bi bi-code-square"></i>
                    <span class="app-menu__label">Data Pengguna</span>
                </a>
            </li>
        @endif
 @endif

    </ul>
    </aside>