@extends('adminlte::page')

@section('title', 'レシピ一覧')

@section('content_header')
    <h1>レシピ一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                検索ワード<b class="color-pink"> "{{ $keyword }}" </b>で検索したところ、<b class="color-pink"> "{{ $recipes->count() }}"</b>件 ヒットしました。
            </div>
            <div class="input-group mb-3">
                <form action="{{ url('/search-recipes') }}" method="get" class="d-flex">
                    <input type="text" name="keyword" class="form-control search-window" placeholder="キーワードを入力">
                    <button class="btn btn-pink" type="submit" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
                </form>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">レシピ一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('create-recipe') }}" class="btn btn-primary">レシピ登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>画像</th>
                                <th>名前</th>
                                <th>食材</th>
                                <!-- TODO:レビュー機能実装 -->
                                <th>レビュー</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($recipes as $recipe)
                            <tr>
                                <td><a href="{{ url('/detail-recipe/'. $recipe->id ) }}">
                                    <div class="upload-image">
                                        @if ( $recipe->image != null )
                                        <img src="data:image/png;base64,{{ $recipe->image }}" alt="レシピ写真">
                                        @endif
                                    </div>
                                </a></td>
                                <td><a href="{{ url('/detail-recipe/'. $recipe->id ) }}">{{ $recipe->name }}</a></td>
                                <td>
                                    <div class="row">
                                        @php $colCount = 0; @endphp
                                        @foreach ($recipe->foods as $food)
                                            <div class="col-md-2">
                                                <p>{{ $food->name }}</p>
                                                
                                                <!-- 列が5列並んだ時、新しい行が作られる -->
                                                @php $colCount++; @endphp
                                                @if($colCount % 5 == 0)
                                                    </div><div class="row">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td></td>
                                <td><a href="{{ url('/edit-recipe/' . $recipe->id ) }}" class="btn btn-success">編集</a></td>
                                <td>
                                    <form action="">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除していいですか？')">削除</button>
                                    </form>
                                </td>
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
