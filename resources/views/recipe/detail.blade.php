@extends('adminlte::page')

@section('title', 'レシピ詳細')

@section('content_header')
    <h1>レシピ詳細</h1>
@stop

@section('content')
<div class="row">
    <div class="col-10">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">レシピ詳細</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <div class="input-group-append">
                            <form action="{{ url('/detail-recipe/'. $recipe->id ) }}" method="GET">
                            @csrf
                                <input type="hidden" name="toEditPage" value="true">
                                <button type="submit" class="btn btn-success">レシピ編集</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body d-flex">
                <div class="col-md-7">
                    <h2 class="mb-1 recipe-name">{{ $recipe->name }}</h2>
                    <div class="mb-1">
                        <span class="mr-2">{{ $recipe->category }}</span>
                        <span class="">レビュー</span>
                    </div>
                    <div class="recipe-image my-3">
                        <img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ写真">
                    </div>

                    <!-- 画像・リンク・共有 -->
                    <p class="my-1">参考リンク：<a href="{{ $recipe->link }}">{{ $recipe->link }}</a></p>
                    <p>作成日：{{ $recipe->created_at }}</p>
                    <!-- TODO:印刷ボタン・共有ボタン・Herokuあげたらリンク先の設定する -->
                    <div class="d-flex">
                        <!-- 印刷ボタン -->
                        <form class="print-area mr-1">                            
                            <img src="{{ asset('img/printer-fill.svg') }}" alt="印刷ボタン">
                            <input type="button" id="print" onclick="window.print();">
                        </form>
                        <!-- Lineボタン -->
                        <div class="line-it-button" data-lang="ja" data-type="share-b" data-env="REAL" data-url="http://127.0.0.1:8000/detail-recipe/3" data-color="default" data-size="small" data-count="false" data-ver="3" style="display: none;"></div>
                        <!-- twitterボタン -->
                        <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="true" data-url="" data-size="large"></a>
                    </div>
                </div>

                <!-- 材料 -->
                <div class="col-md-4 food-ready-area">
                    <div class="row">
                        <h4 class="mt-2">材料</h4>
                        @php $colCount = 0; @endphp
                        @foreach ($recipe->foods as $food)
                        <p class="food-border">{{ $food->name }}</p>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-body  table-responsive">
                <div class="col-md-12 dot-border">
                    <h4>作り方</h4>
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th class="col-md-2">順番</th>
                                <th class="col-md-4">手順</th>
                                <th class="col-md-6">詳細</th>
                            </tr>
                        </thead>
                        <tbody>
                        @for ($i = 0; $i < 8; $i++)
                        @php
                            $heading = 'heading_' . $i;
                            $detail = 'detail_' . $i;
                        @endphp
                        @if(isset($recipe->{$heading}) || isset($recipe->{$detail}))
                            <tr>
                                <td class="col-md-2">{{$i+1}}</td>
                                <td class="col-md-4"><p class="m-0">{{ $recipe->{$heading} }}</p></td>
                                <td class="col-md-6"><p class="m-0">{{ $recipe->{$detail} }}</p></td>
                            </tr>
                        @endif
                        </tbody>
                        @endfor
                    </table>   
                </div>
            </div>

            <div class="card-body solid-border">
                <!-- TODO:おすすめレシピ -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="recommend-area">
                            <img src="" alt="おすすめレシピ画像">
                            <h4></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
