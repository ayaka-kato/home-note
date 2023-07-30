@extends('adminlte::page')

@section('title', '食材一覧')

@section('content_header')
    <h1>食材一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">食材一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('/create-food') }}">食材登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>食材名</th>
                                <th>読み方</th>
                                <th>詳細</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($foods as $food)
                                <tr>
                                    <td>{{ $food->id }}</td>
                                    <td>{{ $food->name }}</td>
                                    <td>{{ $food->read }}</td>
                                    <td>{{ $food->text }}</td>
                                    <td><a href="{{ url('/edit-food/' . $food->id ) }}">編集</a></td>
                                    <td>
                                        <form action="{{ url('/delete-food/' . $food->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" onclick="return confirm('登録済みのレシピからも削除されてしまいますが、本当に削除しますか？')">削除</button>
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
