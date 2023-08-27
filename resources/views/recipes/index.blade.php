@extends('adminlte::page')

@section('title', 'レシピ一覧')

@section('content_header')
    <h1>レシピ一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-sm-10 col-md-12 col-lg-12 col-xl-10">
            @if($keyword)
            <div class=" search-message">
                検索ワード<b class="color-pink"> "{{ $keyword }}" </b>で検索したところ、<b class="color-pink"> "{{ $recipes->count() }}"</b>件 ヒットしました。
            </div>
            @endif
            <div class="input-group">
                <form action="{{ route('indexRecipes') }}" method="get" class="p-0 d-flex">
                    @csrf
                    <input type="text" name="keyword" class="form-control search-window" placeholder="キーワードを入力">
                    <button class="btn btn-success search-btn" type="submit" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
                </form>
            </div>
            <div class="card" id="index-recipe">
                <div class="card-header">
                    <h3 class="card-title">レシピ一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ route('createRecipe') }}" class="btn btn-primary">レシピ登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>画像</th>
                                <th>名前</th>
                                <th>カテゴリ</th>
                                <th>食材</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($recipes as $recipe)
                            <tr>
                                <td class="responsive-img col-4 col-sm-4">
                                    <div class="upload-image">
                                    @if( $recipe->image)
                                    <img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ写真">
                                    @else
                                    <img src="{{ asset('img/no-image.png') }}" alt="レシピ写真">
                                    @endif
                                    </div>
                                </td>
                                <td class="responsive-td col-6 col-sm-6">
                                    <form action="{{ route('getRecipe', [ 'id' => $recipe->id ] ) }}" method="GET">
                                    @csrf
                                        <input type="hidden">
                                        <button type="submit" class="btn btn-link">
                                            <img src="{{ asset('img/file-earmark.svg') }}" alt="レシピイメージ画僧" class="mr-2 mb-1">{{ $recipe->name }}
                                        </button>
                                    </form>
                                </td>
                                <td class="responsive-td col-6 col-sm-6">{{ $recipe->category }}</td>
                                <td class="responsive-td col-6 col-sm-6">
                                    <div class="ingredients-row">
                                        @php $colCount = 0; @endphp
                                        @foreach($recipe->ingredients as $ingredient)
                                            <span class="p-1">{{ $ingredient->ingredient }}</span>
                                            @php $colCount++; @endphp
                                            @if($colCount %4 == 0)
                                                </div><div class="ingredients-row">
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                                @can('controlRecipe', $recipe)
                                <td class="responsive-btn col-1 col-sm-1">
                                    <a href="{{ route('editRecipe', ['id' => $recipe->id ] ) }}" class="btn btn-success">編集</a>
                                </td>
                                <td class="responsive-btn col-1 col-sm-1">
                                    <form action=" {{ route('deleteRecipe', ['id' => $recipe->id])  }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除していいですか？')">削除</button>
                                    </form>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
