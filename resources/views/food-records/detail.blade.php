@extends('adminlte::page')

@section('title', 'ストックデータ詳細')

@section('content_header')
    <h1>ストックデータ詳細</h1>
    <p>登録日：{{ $date->date }}</p>
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