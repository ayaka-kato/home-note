@extends('adminlte::page')

@section('title', '食材編集')

@section('content_header')
    <h1>食材編集</h1>
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
                <form action="{{ url('/update-food/' . $food->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">食材名<span class="color-red">*必須</span></label>
                            <input type="text" class="form-control" id="name" name="name"  value="{{ $food->name }}">
                            <p class="error-msg">{{ $errors->first('name') }}</p>
                        </div>

                        <div class="form-group">
                            <label for="read">読み方(ひらがな)</label>
                            <input type="text" class="form-control" id="read" name="read" pattern="[\u3041-\u3096]*" value="{{ $food->read }}">
                            <p class="error-msg">{{ $errors->first('read') }}</p>
                        </div>
                        
                        <div class="form-group">
                            <label>カテゴリ<span class="color-red">*必須</span></label>
                            <div class="card card-body food-select-area">
                                <div class="row">
                                    <div>
                                        <label for="type-0" class="mr-2"><input type="radio" name="type" id="type-0" value="0" {{ $food->type == 0 ? "checked": null}}>肉類</label>
                                        <label for="type-1" class="mr-2"><input type="radio" name="type" id="type-1" value="1" {{ $food->type == 1 ? "checked": null}}>魚介類</label>
                                        <label for="type-2" class="mr-2"><input type="radio" name="type" id="type-2" value="2" {{ $food->type == 2 ?"checked": null}}>豆類</label>
                                        <label for="type-3" class="mr-2"><input type="radio" name="type" id="type-3" value="3" {{ $food->type == 3 ? "checked": null}}>乳製品</label>
                                        <label for="type-4" class="mr-2"><input type="radio" name="type" id="type-4" value="4" {{ $food->type == 4 ? "checked": null}}>きのこ類</label>
                                        <label for="type-5" class="mr-2"><input type="radio" name="type" id="type-5" value="5" {{ $food->type == 5 ? "checked": null}}>野菜類</label>
                                        <label for="type-6" class="mr-2"><input type="radio" name="type" id="type-6" value="6" {{ $food->type == 6 ? "checked": null}}>果物類</label>
                                        <label for="type-7" class="mr-2"><input type="radio" name="type" id="type-7" value="7" {{ $food->type == 7 ? "checked": null}}>調味料</label>
                                        <label for="type-8" class="mr-2"><input type="radio" name="type" id="type-8" value="8" {{ $food->type == 8 ? "checked": null}}>その他</label>
                                    </div>
                                    <p class="error-msg">{{ $errors->first('text') }}</p>
                                </div>
                            </div>
                            <p class="error-msg">{{ $errors->first('read') }}</p>
                        </div>

                        <div class="form-group">
                            <label for="text">詳細</label>
                            <input type="text" class="form-control" id="text" name="text"  value="{{ $food->text }}">
                            <p class="error-msg">{{ $errors->first('text') }}</p>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary">編集する</button>
                        <button type="submit" class="btn btn-danger">削除する</button>
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

