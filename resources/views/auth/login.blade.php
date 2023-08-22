@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@section('content')
<div class="container welcome-area">
    <div class="row welcome-row align-items-center justify-content-center">
        <div class="col-10 welcome-col flexbox">
            <div class="welcome-image box1">
                <img src="{{ asset('img/top-view.jpg') }}" alt="アプリイメージ画像">
                <ul class="d-flex title-area">
                    <li class="deco">お</li>
                    <li class="deco">う</li>
                    <li class="deco">ち</li>
                    <li class="deco">ノ</li>
                    <li class="deco">ー</li>
                    <li class="deco">ト</li>
                </ul>
            </div>
            <div class="card box2">
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

                            <!-- @if (Route::has('password.request'))
                                <a class="btn btn-link color-pink" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif -->
                        </div>
                    </form>
                </div>
            </div>
            <ul class="pig-run-area">
            @for($i = 0; $i < 10; $i++)
                <li class="pig-run"><img src="{{ asset('img/pig.svg') }}" alt="豚の画像"></li>
            @endfor
            </ul>
        </div>
    </div>
</div>
<script>
window.onload = function() {
    // -------------------------
    // 豚が順番に非表示になる機能
    // -------------------------
    // 対象の番号を設定
    let currentIndex = 0;

    function showPig() {
        // 対象となる豚の画像を配列で取得
        const pigs = document.querySelectorAll('.pig-run');

        // 全ての豚の画像を表示状態にする
        pigs.forEach(pig  => {
            pig.innerHTML = '<img src="{{ asset("img/pig.svg") }}" alt="豚の画像">';
        });

        // 現在の対象の番号の豚の画像を非表示にし、次の番号に更新
        pigs[currentIndex].innerHTML = '<div></div>';

        // '% pigs.length'で配列内の数を超えないようにする
        currentIndex = (currentIndex + 1) % pigs.length;
    }

    // 一定時間ごとにクラスを切り替える
    setInterval(showPig, 500); // 2000ミリ秒（2秒）ごとに切り替える
    showPig(); // 初回実行
};
</script>
@endsection
