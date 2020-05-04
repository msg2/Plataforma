@extends('layouts.app')

@section('content')
<div class="hold-transition login-page">
<div class="container">
    <div class="row justify-content-center">
            <div class="login-box">
                <div class="login-logo">
                    <a href="/login"><b>Mega</b>Project</a>
                </div>
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Sign in to start your session</p>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="input-group mb-3">
                                <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->

                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                            </div>

                            <div class="input-group mb-3">
                                <!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>  -->

                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                            </div>

                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                                </form>
                                
                            </div>

                        @if (Route::has('password.request'))
                        <p class="mb-1">    
                            <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                        </p>
                        @endif
                        <p class="mb-0">
                            <a href="/register" class="text-center">Register a new membership</a>
                        </p>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.navbar 
{
    display:none !important
}
.hold-transition.login-page
{
    background-image: url("images/b.jpg");
}
</style>