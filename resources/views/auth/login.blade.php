@extends('layouts.app')

@section('content')
<div class="container welcome-area">
    <div class="row welcome-row align-items-center justify-content-center">
        <div class="col-md-10 welcome-col d-flex">
            <div class="welcome-image">
                <img src="{{ asset('img/top-view.jpg') }}" alt="アプリイメージ画像">
                <ul class="d-flex">
                    <li class="deco">お</li>
                    <li class="deco">う</li>
                    <li class="deco">ち</li>
                    <li class="deco">ノ</li>
                    <li class="deco">ー</li>
                    <li class="deco">ト</li>
                </ul>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ url('/register') }}" class="color-pink flight">会員登録はこちらから</a>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-0">
                            <button type="submit" class="btn btn-pink mt-2">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link color-pink" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
