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
                                <a href="{{ url('/create-foodRecord') }}" class="btn btn-default">食材在庫データ登録</a>
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
                            @foreach ($dates as $date)
                                <tr>
                                    <td>{{ $date->date }}</td>
                                    <td>{{ $date->latest_update }}</td>
                                    <td>
                                        @if(Carbon\Carbon::now()->format('Y-m-d') == $date->date)
                                        <div class="d-flex">
                                            <a href="{{ url('/edit-foodRecord/' . $date->date ) }}">編集</a>
                                            <!-- 印刷ボタン -->
                                            <form class="print-area mr-1">                            
                                                <img src="{{ asset('img/printer-fill.svg') }}" alt="印刷ボタン">
                                                <input type="button" id="print" onclick="window.print();">
                                            </form>
                                            <!-- Lineボタン -->
                                            <div class="line-it-button" data-lang="ja" data-type="share-b" data-env="REAL" data-url="http://127.0.0.1:8000/detail-recipe/3" data-color="default" data-size="small" data-count="false" data-ver="3" style="display: none;"></div>
                                        </div>
                                        @else
                                        <a href="{{ url('/detail-foodRecord/' . $date->date ) }}">詳細</a>
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
