@extends('layouts.app')

@section('content')

    <div class="hero" style=" background-image: url({{asset('/images1/log.jpg')}});
    " >


        <div class="inner">
            <h1></h1>
        </div>
    </div>
    <BR><br>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <div class="card-header"><h5 class="card-title text-center">{{ __('Login') }}</h5></div>


                        <form class="form-signin" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-label-group">

                                <label for="inputEmail">{{ __('E-Mail Address') }}</label>

                                <input type="email" id="inputEmail"
                                       class="form-control @error('email') is-invalid @enderror" name="email"
                                       value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="form-label-group">

                                <label for="inputPassword">{{ __('Password') }}</label>

                                <input type="password" id="inputPassword"
                                       class="form-control @error('password') is-invalid @enderror " name="password"
                                       required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label"
                                       for="customCheck1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('Remember Me') }}</label>
                            </div>




                            @if (Route::has('password.request'))
                                <a class="special-link " style="color: #e4002b" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                            <BR>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                            <button class="btn-primary1" style=""
                                    type="submit"> {{ __('Login') }}</button>
                                    </div>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
