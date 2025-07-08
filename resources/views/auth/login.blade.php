<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/docs/css/main.css') }}">
    <!-- Font-icon css-->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> --}}
    <title>Login</title>
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
                    <label class="form-label">EMAIL</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                        value="{{ old('email') }}" placeholder="Email" required autofocus
                        oninvalid="this.setCustomValidity('Silakan isi email Anda')"
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
    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
      <i class="bi bi-eye-slash" id="toggleIcon"></i>
    </button>
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
                        <i class="bi bi-box-arrow-in-right me-2 fs-5"></i>LOG IN
                    </button>
                </div>
            </form>

        </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{ 'template/docs/js/jquery-3.7.0.min.js' }}"></script>
    <script src="{{ 'template/docs/js/bootstrap.min.js' }}"></script>
    <script src="{{ 'template/docs/js/main.js' }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script type="text/javascript">
        // Login Page Flipbox control
        $('.login-content [data-toggle="flip"]').click(function() {
            $('.login-box').toggleClass('flipped');
            return false;
        });
    </script>
    <script>
        function togglePassword() {
    const input = document.getElementById("passwordInput");
    const icon = document.getElementById("toggleIcon");
    const isHidden = input.type === "password";

    input.type = isHidden ? "text" : "password";
    icon.classList.toggle("bi-eye", isHidden);
    icon.classList.toggle("bi-eye-slash", !isHidden);
  }
    </script>
</body>

</html>
