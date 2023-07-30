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
                <form action="{{ url('/store-food') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">食材名<span>*必須</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="（例）人参" value="{{ old('name') }}">
                            <p class="error-msg">{{ $errors->first('name') }}</p>
                        </div>

                        <div class="form-group">
                            <label for="read">読み方(ひらがな)</label>
                            <input type="text" class="form-control" id="read" name="read" placeholder="（例）にんじん" pattern="[\u3041-\u3096]*" value="{{ old('read') }}">
                            <p class="error-msg">{{ $errors->first('read') }}</p>
                        </div>

                        <div class="form-group">
                            <label for="text">詳細</label>
                            <input type="text" class="form-control" id="text" name="text" placeholder="（例）〇〇スーパーで安い" value="{{ old('text') }}">
                            <p class="error-msg">{{ $errors->first('text') }}</p>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary">登録する</button>
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

