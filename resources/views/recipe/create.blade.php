@extends('adminlte::page')

@section('title', 'レシピ登録')

@section('content_header')
    <h1>レシピ登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form method="POST" action="{{ url('/store-recipe') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="image">画像</label>
                            <div id="previewImage"></div>
                            <input type="file" class="form-control" id="image" name="image" placeholder="（例）https//...">
                        </div>
                        <div class="form-group">
                            <label for="name">レシピ名</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="（例）肉じゃが">
                        </div>
                        <div class="form-group">
                            <label for="food">食材</label>
                            <a href="{{ url('/create-food') }}">食材の登録をする</a>
                            <select name="food" id="food">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="link">参考リンク</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="（例）https//...">
                        </div>

                        <div class="form-group">
                            <label for="heading-0">小見出し1</label>
                            <input type="text" class="form-control" id="heading-0" name="heading-0" placeholder="（例）手順1">
                        </div>
                        <div class="form-group">
                            <label for="detail-0">詳細1</label>
                            <textarea type="text" class="form-control" id="detail-0" name="detail-0" placeholder="（例）一口サイズに切る"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn add-Btn" id="addBtn-0" data-id="0">入力欄2を追加</button>
                        </div>

                        <!-- 追加項目 -->
                        @for($i = 1; $i < 8; $i++)
                        <div id="addForm-{{ $i }}" class="addForm" style="display:none;">
                            <div class="form-group" id="add-heading-{{ $i }}">
                                <label for="heading-{{ $i }}">小見出し{{ $i + 1 }}</label>
                                <input type="text" class="form-control" id="heading-{{ $i }}" name="heading-{{ $i }}">
                            </div>
                            <div class="form-group" id="add-detail-{{ $i }}">
                                <label for="detail-{{ $i }}">詳細{{ $i + 1 }}</label>
                                <textarea class="form-control" id="detail-{{ $i }}" name="detail-{{ $i }}"></textarea>

                            </div>

                            @if($i == 7)
                            <!-- <button type="button" class="btn add-Btn" id="addBtn-{{ $i }}" data-id="{{ $i }}">入力欄{{ $i + 2 }}を追加</button> -->
                            @else
                            <button type="button" class="btn add-Btn" id="addBtn-{{ $i }}" data-id="{{ $i }}">入力欄{{ $i + 2 }}を追加</button>
                            @endif
                            <button type="button" class="btn delete-Btn" id="deleteBtn-{{ $i }}" data-id="{{ $i }}">入力欄{{ $i + 1 }}を削除</button>

                        </div>
                        @endfor
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
