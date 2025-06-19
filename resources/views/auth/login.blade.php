{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

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
  <h3 class="login-head"><i class="bi bi-person me-2"></i>LOG IN</h3>

  <div class="mb-3">
    <label class="form-label">USERNAME</label>
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
        <span class="text-muted">Belum punya akun? </span>
        <a href="{{ route('register') }}" >Daftar Disini</a>
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
    <script src="{{('template/docs/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{('template/docs/js/bootstrap.min.js')}}"></script>
    <script src="{{('template/docs/js/main.js')}}"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>