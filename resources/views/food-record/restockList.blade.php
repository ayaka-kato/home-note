@extends('adminlte::page')

@section('title', 'お買い物リスト')

@section('content_header')
    <h1>お買い物リスト</h1>
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

            <div class="card card-primary">
                <form method="POST" action="{{ url('/update-foodRecord/') }}">
                    @csrf
                    <div class="card-body">

                        <table class="table table-hover text-nowrap record-table">
                            <thead>
                                @if(session('message'))
                                    <p>{{ session('message') }}</p>
                                @endif
                                <tr>
                                    <th class="form-group">
                                        <p>食材</p>
                                    </th>
                                    <th class="form-group">
                                        <p>理想在庫</p>
                                    </th>
                                    <th class="form-group">
                                        <p>実在庫</p>
                                    </th>
                                    <th class="form-group">
                                        <p>補充数量・コメント</p>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="records-container">
                                <!-- DBに登録がある場合 -->
                                @foreach($foodRecords as $index=>$foodRecord)
                                <tr id="food-record-{{ $index }}" class="food-record">                            
                                    <td class="form-group ingredient-name">
                                        {{ $foodRecord->ingredient }}
                                    </td>
                                    <td class="form-group ideal-amount">
                                        {{ $foodRecord->ideal_amount }}
                                    </td>
                                    <td class="form-group real-amount">
                                        {{ $foodRecord->real_amount == "0" ? "ない" : "少ない" }}
                                    </td>
                                    <td class="form-group restock-amount">
                                        <input type="text" name="restock-amount-{{ $index }}" class="form-control" value="{{ old('restock-amount-' . $index , $foodRecord->restock_amount) }}">
                                    </td>
                                    <td class="form-group delete-record">
                                        <button type="button" class="btn btn-danger delete-Btn mt-3" id="deleteBtn-{{ $index }}" data-id="{{ $index }}">削除</button>
                                    </td>                                
                                </tr>
                                @endforeach
                            </tbody>

                            <!-- 新規登録がある場合 -->

                        </table>
                        <button type="button" class="btn btn-success" id="addRecordBtn">追加</button>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">登録</button>
                        </div>
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