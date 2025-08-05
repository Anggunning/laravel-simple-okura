<header class="app-header">
    {{-- <a class="app-header__logo" href="index.html">Simpel Okura</a> --}}
    <a class="app-header__logo d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
        <img src="{{ asset('pekanbaru.png') }}" alt="Logo Pekanbaru" style="height: 30px;">
        Simpel Okura
    </a>

    <!-- Sidebar toggle button-->
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
            {{-- Penduduk Miskin --}}
            
    <ul class="app-nav">
      @if (in_array(auth()->user()->role, ['Admin', 'Lurah', 'Sekretaris']))
        <li class="dropdown">
            <a class="app-nav__item show" href="#" data-bs-toggle="dropdown" aria-label="Show notifications"
                aria-expanded="true">
                <i class="bi bi-bell fs-5"></i>
                <span class="badge bg-danger" id="jumlah-notifikasi"></span>
            </a>
            <ul class="app-notification dropdown-menu dropdown-menu-right" id="daftar-notifikasi">
                <li class="app-notification__title">Memuat notifikasi...</li>
        </li>
    </ul>
@endif

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
{{-- 
<script>
    function loadNotifikasi() {
        $.ajax({
            url: '/notifikasi',
            method: 'GET',
            success: function(res) {
                let html = '';
                if (res.data.length > 0) {
                    html +=
                        `<li class="app-notification__title">Terdapat ${res.jumlah} notifikasi baru${res.jumlah > 1 ? '' : ''}.</li>`;
                    html += `<div class="app-notification__content">`
                    res.data.forEach(n => {
    html += `
        <li>
          
           <a class="app-notification__item notifikasi-item" href="javascript:void(0)" data-id="${n.id}" data-url="${n.url}">
            
                <span class="app-notification__icon"></span>
                <div>
                    <p class="app-notification__message">${n.message}</p>
                    <p class="app-notification__meta">${n.time}</p>
                </div>
            </a>
        </li>
    `;
});

                    html += `</div>`;
                    
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

       $(document).on('click', '.notifikasi-item', function (e) {
    e.preventDefault(); // Jangan langsung redirect

    const item = $(this);
    const id = item.data('id');
    const url = item.data('url'); // AMAN

    console.log('Arahkan ke:', url); // DEBUG

    $.ajax({
        url: `/notifikasi/baca/${id}`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function () {
            item.closest('li').remove();
            const jumlah = parseInt($('#jumlah-notifikasi').text()) || 0;
$('#jumlah-notifikasi').text(jumlah > 1 ? jumlah - 1 : '');


            setTimeout(() => {
                window.location.href = url;
            }, 200);
        },
        error: function () {
            alert('Gagal menghapus notifikasi');
        }
    });
});



    });
</script> --}}

<script>
    function loadNotifikasi() {
        $.ajax({
            url: '/notifikasi',
            method: 'GET',
            success: function(res) {
                let html = '';
                const terbaca = JSON.parse(localStorage.getItem('notifikasiTerbaca') || '[]');

                // Filter notifikasi yang belum dibaca
                const notifikasiBaru = res.data.filter(n => !terbaca.includes(n.id));

                if (notifikasiBaru.length > 0) {
                    html += `<li class="app-notification__title">Terdapat ${notifikasiBaru.length} notifikasi baru.</li>`;
                    html += `<div class="app-notification__content">`;

                    notifikasiBaru.forEach(n => {
                        html += `
                            <li>
                                <a class="app-notification__item notifikasi-item" href="javascript:void(0)" data-id="${n.id}" data-url="${n.url}">
                                    <span class="app-notification__icon"></span>
                                    <div>
                                        <p class="app-notification__message">${n.message}</p>
                                        <p class="app-notification__meta">${n.time}</p>
                                    </div>
                                </a>
                            </li>
                        `;
                    });

                    html += `</div>`;
                } else {
                    html = `<li class="app-notification__title">Tidak ada notifikasi.</li>`;
                }

                $('#daftar-notifikasi').html(html);
                $('#jumlah-notifikasi').text(notifikasiBaru.length > 0 ? notifikasiBaru.length : '');
            },
            error: function() {
                $('#daftar-notifikasi').html('<li class="app-notification__title text-danger">Gagal memuat notifikasi</li>');
            }
        });
    }

    $(document).ready(function() {
        loadNotifikasi();
        setInterval(loadNotifikasi, 30000); // per 30 detik

        // Ketika user klik notifikasi
        $(document).on('click', '.notifikasi-item', function (e) {
            e.preventDefault();

            const item = $(this);
            const id = item.data('id');
            const url = item.data('url');

            // Simpan notifikasi yang sudah dibaca ke localStorage
            let terbaca = JSON.parse(localStorage.getItem('notifikasiTerbaca') || '[]');
            if (!terbaca.includes(id)) {
                terbaca.push(id);
                localStorage.setItem('notifikasiTerbaca', JSON.stringify(terbaca));
            }

            // Update tampilan manual (langsung hapus item)
            item.closest('li').remove();

            // Update jumlah badge
            const jumlah = parseInt($('#jumlah-notifikasi').text()) || 0;
            $('#jumlah-notifikasi').text(jumlah > 1 ? jumlah - 1 : '');

            // Redirect ke halaman tujuan
            setTimeout(() => {
                window.location.href = url;
            }, 100);
        });
    });
</script>

<script>
    // Saat logout atau reload session
    function resetNotifikasiTerbaca() {
        localStorage.removeItem('notifikasiTerbaca');
    }
</script>

