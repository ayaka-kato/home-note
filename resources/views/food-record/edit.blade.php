@extends('adminlte::page')

@section('title', '冷蔵庫チェックリスト編集')

@section('content_header')
    <h1>冷蔵庫チェックリスト編集</h1>
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
                <form method="POST" action="{{ url('/update-foodRecord/' . $date ) }}">
                    @csrf
                    <div class="card-body">
                    <button type="button" id="exe-btn">反映する</button>
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
                                    <p>廃棄数</p>
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
                                    <input type="text" name="ingredient-{{ $index }}" class="form-control" value="{{ old('ingredient-' . $index , $foodRecord->ingredient ) }}">
                                </td>
                                <td class="form-group ideal-amount">
                                    <input type="text" name="ideal-amount-{{ $index }}" class="form-control" value="{{ old('ideal-amount-' . $index , $foodRecord->ideal_amount) }}">
                                </td>
                                <td class="form-group real-amount">
                                    <div class="form-control">
                                        <input type="radio" name="real-amount-{{ $index }}" value="0" {{ (old('real-amount-' . $index) === "0" || $foodRecord->real_amount === 0) ? "checked" : "" }}>ない
                                        <input type="radio" name="real-amount-{{ $index }}" value="1" {{ (old('real-amount-' . $index) === "1" || $foodRecord->real_amount === 1) ? "checked" : "" }}>少ない
                                        <input type="radio" name="real-amount-{{ $index }}" value="2" {{ (old('real-amount-' . $index) === "2" || $foodRecord->real_amount === 2) ? "checked" : "" }}>多い
                                    </div>
                                </td>
                                <td class="form-group waste-amount">
                                    <div class="form-control">
                                        <input type="radio" name="waste-amount-{{ $index }}" value="1" {{ (old('waste-amount-' . $index) === "1" || $foodRecord->waste_amount === 1) ? "checked" : "" }}>少ない
                                        <input type="radio" name="waste-amount-{{ $index }}" value="2" {{ (old('waste-amount-' . $index) === "2" || $foodRecord->waste_amount === 2) ? "checked" : "" }}>多い
                                    </div>
                                </td>
                                <td class="form-group restock-amount">
                                    <input type="text" name="restock-amount-{{ $index }}" class="form-control" value="{{ old('restock-amount-' . $index , $foodRecord->restock_amount) }}">
                                </td>
                                <td class="form-group delete-record">
                                    <button type="button" class="btn btn-danger delete-Btn mt-3" id="deleteBtn-{{ $index }}" data-id="{{ $index }}">削除</button>
                                </td>                                
                            </tr>
                            @endforeach

                            <!-- 新規登録をする場合 -->

                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success" id="addRecordBtn">追加</button>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
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