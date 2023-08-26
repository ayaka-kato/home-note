@extends('adminlte::page')
<!-- TODO: -->
@section('title', 'ホーム')

@section('content_header')
    <h1>ホーム</h1>
@stop

@section('content')

<div class="container-fluid">    
    <div class="row">
        <div class="col-10">
            <p>集計期間：{{ $start_date }} ～ {{ $end_date }}</p>
            
            <p>捨てた数が多い食材ランキング</p>
            <div>
                <table class="table col-12 col-md-8 text-center">
                    <tr>
                        <td>1位</td>
                        <td>{{ $rankings[0]->ingredient }}</td>
                    </tr>
                        <td>2位</td>
                        <td>{{ $rankings[1]->ingredient }}</td>
                    </tr>
                        <td>3位</td>
                        <td>{{ $rankings[2]->ingredient }}</td>
                    </tr>
                </table>
            </div>
            <br>
            
            <p>おすすめメニュー</p>
            <div class="d-flex">
                @foreach($useUpRecipes as $recipe)
                <div class="card w-50 mr-1">
                    <a href="{{ route('getRecipe', ['id' => $recipe->id ] ) }}">
                        <div class="card-body"><img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ画像"></div>
                        <div class="card-header"><p>{{ $recipe->name }}</p></div>
                    </a>
                </div>
                @endforeach

                @foreach($recommendRecipes as $recipe)
                <div class="card w-50 mr-1">
                    <a href="{{ route('getRecipe', [ 'id' => $recipe->id ] ) }}">
                        <div class="card-body"><img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ画像"></div>
                        <div class="card-header"><p>{{ $recipe->name }}</p></div>
                    </a>
                </div>
                @endforeach
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

