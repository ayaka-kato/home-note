@extends('adminlte::page')

@section('title', '食材在庫データ一覧')

@section('content_header')
    <h1>食材在庫データ一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">食材在庫データ一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ route('createRecord') }}" class="btn btn-default">食材在庫データ登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>登録日</th>
                                <th>更新日時</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($foodRecords as $record)
                                <tr>
                                    <td>{{ $record->date }}</td>
                                    <td>{{ $record->latest_update }}</td>
                                    <td>
                                        @if(Carbon\Carbon::now()->format('Y-m-d') == $record->date)
                                        <a href="{{ route('editRecord', [ 'id' => $record->date ] ) }}">編集</a>
                                        @else
                                        <!-- TODO: -->
                                        <a href="{{ url('/detail-foodRecord/' . $record->date ) }}">詳細</a>
                                        @endif
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
