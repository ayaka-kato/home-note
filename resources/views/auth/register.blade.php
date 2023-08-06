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
                <div class="card-body text-center p-0">
                    <a href="{{ url('/login') }}" class="color-orange flight">ログインはこちらから</a>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <table class="text-left">
                            <tr>
                                <td>
                                    <label for="name">{{ __('Name') }}</label>
                                </td>
                                <td>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                </td>
                                <td>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="password">{{ __('Password') }}</label>
                                </td>
                                <td>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                </td>
                                <td>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-orange mt-2">
                                        {{ __('Register') }}
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
