
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('template/docs/css/main.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Font-icon css-->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> --}}
    <title>Register</title>
    
    <style>
    body {
        background-image: url('{{ asset('bg-login.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    /* Opsional: tambahkan overlay agar login box lebih jelas */
    .register-content::before {
        content: "";
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 0;
    }

    .register-box {
        position: relative;
        z-index: 1;
    }

    /* Hilangkan material-half-bg agar tidak tumpuk */
    .material-half-bg {
        display: none;
    }
    .register-content {
    background-color: transparent;
}

</style>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="register-content">
      <div class="register-box">
        <form class="register-form" method="POST" action="{{ route('register') }}">
  @csrf
   
  <h3 class="register-head d-flex align-items-center justify-content-center gap-2">
    <img src="{{ asset('pekanbaru.png') }}" alt="Logo Pekanbaru" style="height: 40px;"></i>REGISTER</h3>

  <div class="mb-3">
    <label class="form-label">USERNAME</label>
    <input class="form-control @error('username') is-invalid @enderror"
    type="text"
    name="username"
    value="{{ old('username') }}"
    placeholder="Username"
    required
    oninvalid="this.setCustomValidity('Silakan isi username Anda')"
    oninput="this.setCustomValidity('')">

  </div>
  <div class="mb-3">
    <label class="form-label">EMAIL</label>
    <input class="form-control @error('email') is-invalid @enderror"
    type="email"
    name="email"
    value="{{ old('email') }}"
    placeholder="Email"
    required
    oninvalid="this.setCustomValidity('Silakan isi email yang valid')"
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
    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()" id="toggleButton">
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
        <span class="text-muted">Sudah punya akun? </span>
        <a href="{{ route('login') }}" >Masuk Disini</a>
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
      <i ></i>REGISTER
    </button>
  </div>
  

</form>

      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{('template/docs/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{('template/docs/js/bootstrap.min.js')}}"></script>
    <script src="{{('template/docs/js/main.js')}}"></script>
    <script type="text/javascript">
      // register Page Flipbox control
      $('.register-content [data-toggle="flip"]').click(function() {
      	$('.register-box').toggleClass('flipped');
      	return false;
      });
    </script>
    {{-- Tambahkan CDN SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
</script>
@endif

@if ($errors->any())
<script>
    let errorList = @json($errors->all());

    Swal.fire({
        icon: 'error',
        title: 'Gagal mendaftar!',
        html: '<ul style="list-style: none; padding-left: 0; text-align: left; margin: 0;">' + errorList.map(e => `<li>${e}</li>`).join('') + '</ul>',
        confirmButtonColor: '#d33',
        confirmButtonText: 'OK'
    });
</script>
@endif


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
