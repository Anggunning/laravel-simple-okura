
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('template/docs/css/main.css')}}">
    <!-- Font-icon css-->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> --}}
    <title>Register</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="register-content">
      <div class="register-box">
        <form class="register-form" method="POST" action="{{ route('register') }}">
  @csrf
  <h3 class="register-head"><i class="bi bi-person me-2"></i>REGISTER</h3>

  <div class="mb-3">
    <label class="form-label">USERNAME</label>
    <input class="form-control @error('username') is-invalid @enderror" type="username" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
    @error('username')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
    @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">EMAIL</label>
    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
    @error('email')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
    @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">PASSWORD</label>
    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" required>
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
      <i class="bi bi-box-arrow-in-right me-2 fs-5"></i>REGISTER
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
  </body>
</html>
</html>