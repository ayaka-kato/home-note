@extends('adminlte::page')

@section('title', '食材登録')

@section('content_header')
    <h1>食材登録</h1>
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
                <form action="{{ url('/store-food') }}" method="POST" id="foodForm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">食材名<span class="color-red">*必須</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="（例）人参" value="{{ old('name') }}" autofocus>
                            <p class="error-msg">{{ $errors->first('name') }}</p>
                        </div>

                        <div class="form-group">
                            <label for="read">読み方(ひらがな)</label>
                            <input type="text" class="form-control" id="read" name="read" placeholder="（例）にんじん" pattern="[\u3041-\u3096ー]*" value="{{ old('read') }}">
                            <p class="error-msg">{{ $errors->first('read') }}</p>
                        </div>

                        <div class="form-group">
                            <label>カテゴリ<span class="color-red">*必須</span></label>
                            <div class="card card-body food-select-area">
                                <div class="row">
                                    <div>
                                        <label for="type-0" class="mr-2"><input type="radio" name="type" id="type-0" value="肉類" {{ old('type') == "肉類" ? "checked": null}}>肉類</label>
                                        <label for="type-1" class="mr-2"><input type="radio" name="type" id="type-1" value="魚介類" {{ old('type') == "魚介類" ? "checked": null}}>魚介類</label>
                                        <label for="type-2" class="mr-2"><input type="radio" name="type" id="type-2" value="豆類" {{ old('type') == "豆類" ? "checked": null}}>豆類</label>
                                        <label for="type-3" class="mr-2"><input type="radio" name="type" id="type-3" value="乳製品" {{ old('type') == "乳製品" ? "checked": null}}>乳製品</label>
                                        <label for="type-4" class="mr-2"><input type="radio" name="type" id="type-4" value="きのこ類" {{ old('type') == "きのこ類" ? "checked": null}}>きのこ類</label>
                                        <label for="type-5" class="mr-2"><input type="radio" name="type" id="type-5" value="野菜類" {{ old('type') == "野菜類" ? "checked": null}}>野菜類</label>
                                        <label for="type-6" class="mr-2"><input type="radio" name="type" id="type-6" value="果物類" {{ old('type') == "果物類" ? "checked": null}}>果物類</label>
                                        <label for="type-7" class="mr-2"><input type="radio" name="type" id="type-7" value="調味料" {{ old('type') == "調味料" ? "checked": null}}>調味料</label>
                                        <label for="type-8" class="mr-2"><input type="radio" name="type" id="type-8" value="その他" {{ old('type') == "その他" ? "checked": null}}>その他</label>
                                    </div>
                                    <p class="error-msg">{{ $errors->first('text') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="text">詳細</label>
                            <input type="text" class="form-control" id="text" name="text" placeholder="（例）〇〇スーパーで安い" value="{{ old('text') }}">
                            <p class="error-msg">{{ $errors->first('text') }}</p>
                        </div>
                    </div>
                    <div class="form-footer">
                        <input type="hidden" name="continue_input" value="1">
                        <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event)">登録する</button>
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

