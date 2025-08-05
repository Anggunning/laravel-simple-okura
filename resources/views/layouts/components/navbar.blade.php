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
        <li class="dropdown">
            <a class="app-nav__item show" href="#" data-bs-toggle="dropdown" aria-label="Show notifications"
                aria-expanded="true">
                <i class="bi bi-bell fs-5"></i>
                <span class="badge bg-danger" id="jumlah-notifikasi"></span>
            </a>
            <ul class="app-notification dropdown-menu dropdown-menu-right" id="daftar-notifikasi">
                <li class="app-notification__title">Memuat notifikasi...</li>
        </li>

        {{-- <li class="dropdown">
      <a class="app-nav__item show" href="#" data-bs-toggle="dropdown" aria-label="Show notifications" aria-expanded="true"><i class="bi bi-bell fs-5"></i></a>
          <ul class="app-notification dropdown-menu dropdown-menu-right show" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-0.8px, 53.6px, 0px);" data-popper-placement="bottom-end">
            <li class="app-notification__title">You have 4 new notifications.</li>
            <div class="app-notification__content">
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><i class="bi bi-envelope fs-4 text-primary"></i></span>
                  <div>
                    <p class="app-notification__message">Lisa sent you a mail</p>
                    <p class="app-notification__meta">2 min ago</p>
                  </div></a></li>
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><i class="bi bi-exclamation-triangle fs-4 text-warning"></i></span>
                  <div>
                    <p class="app-notification__message">Mail server not working</p>
                    <p class="app-notification__meta">5 min ago</p>
                  </div></a></li>
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><i class="bi bi-cash fs-4 text-success"></i></span>
                  <div>
                    <p class="app-notification__message">Transaction complete</p>
                    <p class="app-notification__meta">2 days ago</p>
                  </div></a></li>
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><i class="bi bi-envelope fs-4 text-primary"></i></span>
                  <div>
                    <p class="app-notification__message">Lisa sent you a mail</p>
                    <p class="app-notification__meta">2 min ago</p>
                  </div></a></li>
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><i class="bi bi-exclamation-triangle fs-4 text-warning"></i></span>
                  <div>
                    <p class="app-notification__message">Mail server not working</p>
                    <p class="app-notification__meta">5 min ago</p>
                  </div></a></li>
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><i class="bi bi-cash fs-4 text-success"></i></span>
                  <div>
                    <p class="app-notification__message">Transaction complete</p>
                    <p class="app-notification__meta">2 days ago</p>
                  </div></a></li>
            </div>
            <li class="app-notification__footer"><a href="#">See all notifications.</a></li>
          </ul>
        </li> --}}
    </ul>

    <!-- User Menu-->
    @if (Auth::check())
        <li class="dropdown"><a class="app-nav__item" href="#" data-bs-toggle="dropdown"
                aria-label="Open Profile Menu"><i class="bi bi-person fs-4"></i></a>
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
    @endif
    </ul>
</header>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function loadNotifikasi() {
        $.ajax({
            url: '/notifikasi',
            method: 'GET',
            success: function(res) {
                let html = '';
                if (res.data.length > 0) {
                    html +=
                        `<li class="app-notification__title">You have ${res.jumlah} new notification${res.jumlah > 1 ? 's' : ''}.</li>`;
                    html += `<div class="app-notification__content">`;
                    res.data.forEach(n => {
    html += `
        <li>
           <a class="app-notification__item" href="/${n.url}" data-id="${n.id}">
                <span class="app-notification__icon">
                 
                </span>
                <div>
                    <p class="app-notification__message">${n.message}</p>
                    <p class="app-notification__meta">${n.time}</p>
                </div>
            </a>
        </li>
    `;
                    });
                    html += `</div>`;
                    html +=
                        `<li class="app-notification__footer"><a href="#">Lihat semua notifikasi</a></li>`;
                } else {
                    html = `<li class="app-notification__title">Tidak ada notifikasi.</li>`;
                }

                $('#daftar-notifikasi').html(html);
                $('#jumlah-notifikasi').text(res.jumlah);
            },
            error: function() {
                $('#daftar-notifikasi').html(
                    '<li class="app-notification__title text-danger">Gagal memuat notifikasi</li>');
            }
        });
    }

    $(document).ready(function() {
        loadNotifikasi();
        setInterval(loadNotifikasi, 30000); // 30 detik sekali

        $(document).on('click', '.notifikasi-item a', function () {
    const item = $(this).closest('.notifikasi-item');
    const id = item.data('id');
    const url = $(this).data('url');

    // Opsional: tandai notifikasi sudah dibaca di server
    $.ajax({
        url: `/notifikasi/baca/${id}`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function () {
            item.remove(); // Hapus dari tampilan
            window.location.href = url; // Arahkan ke halaman pengajuan
        },
        error: function () {
            alert('Gagal menghapus notifikasi');
        }
    });
});

    });
</script>
@php
    \Carbon\Carbon::setLocale('id');
@endphp
