@extends('adminlte::page')

@section('title', '冷蔵庫チェックリスト')

@section('content_header')
    <h1>冷蔵庫チェックリスト</h1>
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
                <form method="POST" action="{{ url('/store-foodRecord') }}">
                    @csrf
                    <div class="card-body">
                    <table class="table table-hover text-nowrap record-table">
                        <thead>
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
                            @for($i = 0; $i < 5; $i++)
                            <tr id="food-record-{{ $i }}" class="food-record">                              
                                <td class="form-group ingredient-name">
                                    <input type="text" name="ingredient-{{ $i }}" class="form-control" placeholder="（例）人参" value="{{ old('ingredient') }}">
                                </td>
                                <td class="form-group">
                                    <input type="text" name="ideal-amount-{{ $i }}" class="form-control" placeholder="（例）2本"  value="{{ old('ideal-amount') }}">
                                </td>
                                <td class="form-group">
                                    <div class="form-control">
                                        <input type="radio" name="real-amount-{{ $i }}" value="0" {{ old('real-amount-' .$i ) == "0" ? "checked" : null }}>ない
                                        <input type="radio" name="real-amount-{{ $i }}" value="1" {{ old('real-amount-' .$i ) == "1" ? "checked" : null }}>少ない
                                        <input type="radio" name="real-amount-{{ $i }}" value="2" {{ old('real-amount-' .$i ) == "2" ? "checked" : null }}>多い
                                    </div>
                                </td>
                                <td class="form-group waste-amount">
                                    <div class="form-control">
                                        <input type="radio" name="waste-amount-{{ $i }}" value="1" {{ old('waste-amount-' .$i ) == "1" ? "checked" : null }}>少ない
                                        <input type="radio" name="waste-amount-{{ $i }}" value="2" {{ old('waste-amount-' .$i ) == "2" ? "checked" : null }}>多い
                                    </div>
                                </td>
                                <td class="form-group restock-amount">
                                    <input type="text" name="restock-amount-{{ $i }}" class="form-control" placeholder="（例）2本"  value="{{ old('restock-amount-' . $i) }}">
                                </td>
                                <td class="form-group delete-record">
                                    <button type="button" class="btn btn-danger delete-Btn mt-3" id="deleteBtn-{{ $i }}" data-id="{{ $i }}">削除</button>
                                </td>                                
                            </tr>
                            @endfor
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