@extends('adminlte::page')

@section('title', '冷蔵庫チェックリスト詳細')

@section('content_header')
    <h1>冷蔵庫チェックリスト詳細</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="d-flex">
            <!-- TODO: -->
                <!-- 印刷ボタン -->
                <form class="print-area mr-1">                            
                    <img src="{{ asset('img/printer-fill.svg') }}" alt="印刷ボタン">
                    <input type="button" id="print" onclick="window.print();">
                </form>
                <!-- Lineボタン -->
                <div class="line-it-button" data-lang="ja" data-type="share-b" data-env="REAL" data-url="http://127.0.0.1:8000/edit-foodRecord/.{{ $date->id }}" data-color="default" data-size="small" data-count="false" data-ver="3" style="display: none;"></div>
                
            </div>
            <div class="card card-primary">
                <div class="card-body">                   
                    <table class="table table-hover text-nowrap record-table col-12">
                        <thead>
                            <tr>
                                <th class="form-group"><p>食材</p></th>
                                <th class="form-group"><p>理想在庫</p></th>
                                <th class="form-group"><p>実在庫</p></th>
                                <th class="form-group"><p>廃棄数</p></th>
                                <th class="form-group"><p>補充数量・コメント</p></th>
                            </tr>
                        </thead>
                        <tbody id="records-container">
                            @foreach($foodRecords as $index=>$foodRecord)
                            <tr>                          
                                <td class="form-group"><p>{{ $foodRecord->ingredient }}</p></td>                             
                                <td class="form-group"><p>{{ $foodRecord->ideal_amount }}</p></td>                             
                                <td class="form-group"><p>{{ $foodRecord->real_amount == 0 ? 'ない' : ($foodRecord->real_amount == 1 ? '少ない' : '多い') }}</p></td>                             
                                <td class="form-group"><p>{{ $foodRecord->waste_amount == 0 ? 'ない' : ($foodRecord->waste_amount == 1 ? '少ない' : '多い') }}</p></td>                             
                                <td class="form-group"><p>{{ $foodRecord->restock_amount }}</p></td>                                                          
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
<script src="{{ asset('js/food-record.js') }}"></script>
@stop