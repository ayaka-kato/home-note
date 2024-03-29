@extends('adminlte::page')

@section('title', 'お買い物リスト')

@section('content_header')
    <h1>お買い物リスト</h1>
    <p>最新登録日：{{ $date }}</p>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="d-flex float-right">
                        <!-- 印刷ボタン -->
                        <form class="print-area mr-1">                            
                            <img src="{{ asset('img/printer-fill.svg') }}" alt="印刷ボタン">
                            <input type="button" class="p-0 m-0" id="print" onclick="window.print();">
                        </form>
                        <!-- Lineボタン -->
                        <div class="line-it-button" data-lang="ja" data-type="share-a" data-env="REAL" data-url="http://home-note-080ff2fd6a87.herokuapp.com/food-records/restockList" data-color="default" data-size="small" style="display: none;"></div>
                    </div>
                </div>
                <div class="card-body">
                    @if($foodRecords->isEmpty())
                    <p>ストックデータの登録がされていません。</p>
                    @else
                    <table class="table table-hover text-nowrap record-table">
                        <thead>
                            @if(session('message'))
                                <p>{{ session('message') }}</p>
                            @endif
                            <tr>
                                <th class="form-group">
                                    <p>番号</p>
                                </th>
                                <th class="form-group">
                                    <p>食材</p>
                                </th>
                                <th class="form-group">
                                    <p>補充数量・コメント</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="records-container">
                            @foreach($foodRecords as $index=>$foodRecord)
                            <tr id="food-record-{{ $index }}" class="food-record">                       
                                <td class="form-group">{{ $index+1 }}</td>
                                <td class="form-group ingredient-name">{{ $foodRecord->ingredient }}</td>
                                <td class="form-group restock-amount">{{ $foodRecord->restock_amount }}</td>                             
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
<script src="https://www.line-website.com/social-plugins/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
@stop