@extends('adminlte::page')
@section('title', 'ホーム')

@section('content_header')
    <h1>ホーム</h1>
@stop

@section('content')

<div class="container-fluid">    
    <div class="row" id="home-view">
        <div class="col-12 col-md-10">          
            <p class="mb-1 slogan">＼ムダを知って貯金を増やす！！／</p>
            <h5 class="color-pink">捨てがち食材ランキング</h5>
            <div>
                @if(count($rankings) > 0)
                <table class="table col-12 col-md-8 text-center mb-0">
                    <tr>
                        <td>1位</td>
                        <td>{{ $rankings[0]->ingredient }}</td>
                    </tr>
                    @if(count($rankings) > 1 && isset($rankings[1]->ingredient))
                    <tr>
                        <td>2位</td>
                        <td>{{ $rankings[1]->ingredient }}</td>
                    </tr>
                    @endif
                    @if(count($rankings) > 2 && isset($rankings[2]->ingredient))
                    <tr>
                        <td>3位</td>
                        <td>{{ $rankings[2]->ingredient }}</td>
                    </tr>
                    @endif
                </table>
                <p class="mb-0 sum-period">(集計期間：{{ $start_date }} ～ {{ $end_date }})</p>
                @else
                <p>※データが未登録です。</p>
                @endif
            </div>
            <br>
            
            
            <div class="">
                @if($rankings->isEmpty())
                <h5 class="color-pink mb-3">おすすめメニュー</h5>
                @else
                <h5 class="color-pink mb-3">食材の使い切りにおすすめなメニュー♪</h5>
                <div class="recommend-recipe">
                    @foreach($useUpRecipes as $recipe)
                    <div class="card">
                        <a href="{{ route('getRecipe', ['id' => $recipe->id ] ) }}">
                            <div class="card-body">
                                @if( $recipe->image)
                                <img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ写真">
                                @else
                                <img src="{{ asset('img/no-image.png') }}" alt="レシピ写真">
                                @endif
                            </div>
                            <div class="card-header"><p>{{ $recipe->name }}</p></div>
                        </a>
                    </div>
                    @endforeach
                </div>
                
                <h5 class="color-pink">ストックを活かして作るおすすめレシピ♪</h5>
                @endif
                <div class="recommend-recipe">
                    @foreach($recommendRecipes as $recipe)
                    <div class="card">
                        <a href="{{ route('getRecipe', [ 'id' => $recipe->id ] ) }}">
                            <div class="card-body">
                                @if( $recipe->image)
                                <img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ写真">
                                @else
                                <img src="{{ asset('img/no-image.png') }}" alt="レシピ写真">
                                @endif
                            </div>
                            <div class="card-header"><p>{{ $recipe->name }}</p></div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

