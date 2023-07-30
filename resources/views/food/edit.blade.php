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
                            <label for="name">食材名<span>*必須</span></label>
                            <input type="text" class="form-control" id="name" name="name"  value="{{ $food->name }}">
                            <p class="error-msg">{{ $errors->first('name') }}</p>
                        </div>

                        <div class="form-group">
                            <label for="read">読み方(ひらがな)</label>
                            <input type="text" class="form-control" id="read" name="read" pattern="[\u3041-\u3096]*" value="{{ $food->read }}">
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
                        <button type="submit" class="btn btn-primary">削除する</button>
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

