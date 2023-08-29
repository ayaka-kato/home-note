@extends('adminlte::page')

@section('title', 'ストックデータ一覧')

@section('content_header')
<div id="index-record" class="d-flex justify-content-between align-items-center">
    <h1>ストックデータ一覧</h1>
    @php $currentDate = Carbon\Carbon::now()->format('Y-m-d'); @endphp
    <div class="right-btn">
        <div class="input-group-append">
            @if ($dates->contains('date', $currentDate))
            @else
            <a href="{{ route('createRecord') }}" class="btn btn-primary">ストックデータ登録</a>
            @endif
        </div>
    </div>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>登録日</th>
                                <th>更新日時</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dates as $date)
                                <tr>
                                    <td>{{ $date->date }}</td>
                                    <td>{{ $date->updated_at }}</td>
                                    <td>
                                        @if($date->date == $currentDate)
                                        <a href="{{ route('editRecord', [ 'id' => $date->id ] ) }}">編集</a>
                                        @else
                                        <a href="{{ route('getRecord', [ 'id' => $date->id ] ) }}">詳細</a>
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
