<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/docs/css/main.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Font-icon css-->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> --}}
    <title>Login</title>

    <style>
    body {
        background-image: url('{{ asset('bg-login.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    /* Opsional: tambahkan overlay agar login box lebih jelas */
    .login-content::before {
        content: "";
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 0;
    }

    .login-box {
        position: relative;
        z-index: 1;
    }

    /* Hilangkan material-half-bg agar tidak tumpuk */
    .material-half-bg {
        display: none;
    }
    .login-content {
    background-color: transparent;
}

</style>

</head>

<body>
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content">
        <div class="login-box">

            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <h3 class="login-head d-flex align-items-center justify-content-center gap-2">
                    <img src="{{ asset('pekanbaru.png') }}" alt="Logo Pekanbaru" style="height: 40px;">
                    <span>LOG IN</span>
                </h3>

                <div class="mb-3">
                    <label class="form-label">NO HP</label>
                    <input class="form-control @error('no_hp') is-invalid @enderror" type="text" name="no_hp"
                        value="{{ old('no_hp') }}" placeholder="No Telepon" required autofocus
                        oninvalid="this.setCustomValidity('Silakan isi no_hp Anda')"
                        oninput="this.setCustomValidity('')">

                </div>

               <div class="mb-3">
  <label class="form-label">PASSWORD</label>
  <div class="input-group">
    <input type="password"
           name="password"
           id="passwordInput"
           class="form-control @error('password') is-invalid @enderror"
           placeholder="Password"
           required
           oninvalid="this.setCustomValidity('Password minimal 8 karakter dan harus mengandung huruf & angka')"
           oninput="this.setCustomValidity('')">
  
  </div>
  @error('password')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>


                <div class="mb-3">
                    <div class="utility">
                        <div class="mb-2 text-center">
                            <span class="text-muted">Belum punya akun? </span>
                            <a href="{{ route('register') }}">Daftar Disini</a>
                            </a>
                        </div>
                        {{-- <p class="semibold-text mb-2">
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" data-toggle="flip">Forgot Password?</a>
        @endif
      </p> --}}
                    </div>
                </div>
                <div class="mb-3 btn-container d-grid">
                    <button class="btn btn-primary btn-block" type="submit">
                        <i></i>LOG IN
                    </button>
                </div>
            </form>

        </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{ 'template/docs/js/jquery-3.7.0.min.js' }}"></script>
    <script src="{{ 'template/docs/js/bootstrap.min.js' }}"></script>
    <script src="{{ 'template/docs/js/main.js' }}"></script>
    {{-- <script type="text/javascript">
        // Login Page Flipbox control
        $('.login-content [data-toggle="flip"]').click(function() {
            $('.login-box').toggleClass('flipped');
            return false;
        });
    </script> --}}
   

</body>

</html>

{{-- <style>
    .material-half-bg .cover {
        background-image: url('{{ asset('bg-kantor.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0.9;
    }
    .material-half-bg .cover::after {
    content: "";
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.4); /* Ubah transparansi sesuai selera */
}
</style> --}}
