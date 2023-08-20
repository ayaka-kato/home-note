@extends('adminlte::page')
<!-- TODO: -->
@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
    <!-- 捨てた数が多いもの -->
    <p>廃棄数が多い食材ランキング</p>
    <p>1位</p><span></span>
    <p>2位</p>
    <p>3位</p>

    <!-- 買った数が多いもの -->
    <p>我が家のスタメン食材ランキング</p>
    <p>1位</p>
    <p>2位</p>
    <p>3位</p>

    <!-- 在庫活用おすすめレシピ（在庫が多い食材を使ったレシピ） -->
    <p>我が家のスタメン食材ランキング</p>
    <p>1位</p>
    <p>2位</p>
    <p>3位</p>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

