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
                @can('controlRecipe', $recipe)
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <div class="input-group-append">
                            <a href="{{ route('editRecipe', ['id' => $recipe->id ] ) }}" class="btn btn-success">レシピ編集</a>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
            <div class="card-body d-flex">
                <div class="col-md-7">
                    <h2 class="mb-1 recipe-name">{{ $recipe->name }}</h2>
                    <div class="mb-1">
                        <span class="mr-2">{{ $recipe->category }}</span>
                    </div>

                    <!-- 画像 -->
                    <div class="recipe-image my-3">
                        <img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ写真">
                    </div>

                    <!-- リンク・共有 -->
                    <p class="my-1">参考リンク：<a href="{{ $recipe->link }}">{{ $recipe->link }}</a></p>
                    <p class="mb-0">作成日：{{ $recipe->created_at }}</p>〖
                    @if ( $recipe->created_at != $recipe->updated_at )
                    <p>更新日：{{ $recipe->updated_at }}</p>
                    @endif
                    <!-- TODO:印刷ボタン・共有ボタン・Herokuあげたらリンク先の設定する -->
                    <div class="d-flex">
                        <!-- 印刷ボタン -->
                        <form class="print-area mr-1">                            
                            <img src="{{ asset('img/printer-fill.svg') }}" alt="印刷ボタン">
                            <input type="button" id="print" onclick="window.print();">
                        </form>
                        <!-- Lineボタン -->
                        <div class="line-it-button" data-lang="ja" data-type="share-a" data-env="REAL" data-url="http://{{ route('getRecipe', ['id' => $recipe->id ] ) }}" data-color="default" data-size="large" data-count="false" data-ver="3" style="display: none;"></div>
                        <!-- twitterボタン -->
                        <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="true" data-text="{{ '〖' . $recipe->name . '〗'}}" data-url="{{ route('getRecipe', ['id' => $recipe->id ] ) }}" data-size="large"></a>
                    </div>
                </div>》

                <!-- 材料 -->
                <div class="col-md-4 food-ready-area ml-5">
                    <div class="row">
                        <h4 class="mt-2">材料</h4>
                        @if( $recipe->serving )
                            <p>{{ $recipe->serving }}</p>
                        @endif
                        @foreach ($ingredients as $ingredient)
                            <p class="food-border">
                                <span>・ {{ $ingredient->ingredient }}</span>
                                <span>{{ $ingredient->amount }}</span>
                            </p>
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
                        @foreach ($processes as $index => $process)
                        @if(isset($process->process) || isset($process->detail))
                            <tr>
                                <td class="col-md-2">{{$index + 1}}</td>
                                <td class="col-md-4"><p class="m-0">{{ $process->process }}</p></td>
                                <td class="col-md-6"><p class="m-0">{{ $process->detail }}</p></td>
                            </tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>

            <div class="card-body">
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
