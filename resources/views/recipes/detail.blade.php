@extends('adminlte::page')

@section('title', 'レシピ詳細')

@section('content_header')
<div id="detail-recipe" class="d-flex">
    <h1>レシピ詳細</h1>
    @can('controlRecipe', $recipe)
    <div class="input-group input-group-sm right-btn">
        <div class="input-group-append">
            <a href="{{ route('editRecipe', ['id' => $recipe->id ] ) }}" class="btn btn-success">レシピ編集</a>
        </div>
    </div>
    @endcan
</div>
@stop

@section('content')
<div class="row" id="detail">
    <div class="col-12 col-md-10">
        <div class="card">
            <div class="card-body info-process">
                <div class="info-area">
                    <div class="col-10 col-md-7">
                        <h2 class="mb-1 recipe-name">{{ $recipe->name }}</h2>
                        <div class="mb-1">
                            <span class="mr-2 category-area">{{ $recipe->category }}</span>
                        </div>
    
                        <!-- 画像 -->
                        <div class="recipe-image my-3">
                            @if( $recipe->image)
                            <img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ写真">
                            @else
                            <img src="{{ asset('img/no-image.png') }}" alt="レシピ写真">
                            @endif
                        </div>
    
                        <!-- リンク・共有 -->
                        <p class="my-1">参考リンク：<a href="{{ $recipe->link }}">{{ $recipe->link }}</a></p>
                        <p class="mb-1">作成日：{{ $recipe->created_at }}</p>
                        @if ( $recipe->created_at != $recipe->updated_at )
                        <p>更新日：{{ $recipe->updated_at }}</p>
                        @endif

                        <div class="d-flex">
                            <!-- 印刷ボタン -->
                            <form class="print-area mr-1">                            
                                <img src="{{ asset('img/printer-fill.svg') }}" alt="印刷ボタン">
                                <input type="button" id="print" onclick="window.print();">
                            </form>
                            <!-- Lineボタン -->
                            <div class="line-it-button" data-lang="ja" data-type="share-a" data-env="REAL" data-url="{{ route('getRecipe', ['id' => $recipe->id ] ) }}" data-color="default" data-size="large" data-count="false" data-ver="3" style="display: none;"></div>
                            <!-- twitterボタン -->
                            <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="true" data-text="{{ '〖' . $recipe->name . '〗'}}" data-url="{{ route('getRecipe', ['id' => $recipe->id ] ) }}" data-size="large"></a>
                        </div>
                    </div>
                    <!-- 材料 -->
                    <div class="col-8 col-md-4 food-ready-area mx-3">
                        <div class="row">
                            <h4 class="mt-2">材料</h4>
                            @if( $recipe->serving )
                                <p class="col-8 col-md-7 serving">（{{ $recipe->serving }}）</p>
                            @endif
                            @foreach ($ingredients as $ingredient)
                                <p class="food-border">
                                    <span class="col-5">・ {{ $ingredient->ingredient }}</span>
                                    <span class="col-5">{{ $ingredient->amount }}</span>
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card-body process-area">
                    <div class="col-12 dot-border">
                        <h4>作り方</h4>
                        <table class="table table-responsive table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th class="col-1">順番</th>
                                    <th class="col-4">手順</th>
                                    <th class="col-4">詳細</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($processes as $index => $process)
                            @if(isset($process->process) || isset($process->detail))
                                <tr class="process">
                                    <td class="col-1">{{$index + 1}}</td>
                                    <td class="col-4"><p class="m-0">{{ $process->process }}</p></td>
                                    <td class="col-4"><p class="m-0">{{ $process->detail }}</p></td>
                                </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>   
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-btn-area">
            <button onclick="scrollToBottom()" class="btn btn-scroll top"><img src="{{ asset('img/arrow-down-circle.svg') }}" alt="画面下へスクロールするアイコン"></button>
            <button onclick="scrollToTop()" class="btn btn-scroll bottom"><img src="{{ asset('img/arrow-up-circle.svg') }}" alt="画面上へスクロールするアイコン"></button>
            <p class="m-0 text-center">スクロールボタン</p>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
<script src="https://www.line-website.com/social-plugins/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script src="{{ asset('js/recipe.js') }}"></script>
@stop
