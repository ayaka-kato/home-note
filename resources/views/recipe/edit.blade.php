@extends('adminlte::page')

@section('title', 'レシピ編集')

@section('content_header')
    <h1>レシピ編集</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">レシピ編集</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <form action=" {{ url('/delete-recipe/' . $recipe->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除していいですか？')">レシピ削除</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ url('/update-recipe') }}" method="post">
                @csrf
                    <div class="card-body d-flex">
                        <!-- 画像・リンク・共有 -->
                        <div class="col-md-8">
                            <h2><input type="text" name="name" value="{{ $recipe->name }}"></h2>
                            <p>{{ $recipe->category }}</p>
                            <div class="">レビュー</div>
                            <div class="recipe-image">
                                <img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ写真">
                            </div>
                            <p>参考リンク：<a href="{{ $recipe->link }}">{{ $recipe->link }}</a></p>
                        </div>
    
                        <!-- 材料 -->
                        <div class="col-md-4">
                            <div class="row">
                                <h4>材料</h4>
                                @php $colCount = 0; @endphp
                                @foreach ($recipe->foods as $food)
                                <p>{{ $food->name }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-10">
                            <h4>作り方</h4>
                            @for ($i = 0; $i < 8; $i++)
                            @php
                                $heading = 'heading_' . $i;
                                $detail = 'detail_' . $i;
                            @endphp
                            <h6>{{ $recipe->{$heading} }}</h6>
                            <p>{{ $recipe->{$detail} }}</p>
    
                            @endfor
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="row">

    </div>
@stop

@section('css')
@stop

@section('js')
@stop
