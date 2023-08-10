@extends('layouts.app')

@section('content')
<div class="container welcome-area">
    <div class="row welcome-row align-items-center justify-content-center">
        <div class="col-md-10 welcome-col d-flex">
            <div class="welcome-image">
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
