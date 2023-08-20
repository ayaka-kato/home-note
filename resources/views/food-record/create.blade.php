@extends('adminlte::page')

@section('title', '冷蔵庫チェックリスト')

@section('content_header')
    <h1>冷蔵庫チェックリスト</h1>
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
                <form method="POST" action="{{ url('/store-foodRecord') }}" id="record-form">
                    @csrf
                    <div class="card-body">
                        <button type="button" id="exe-btn">反映する</button>
                        <table class="table table-hover text-nowrap record-table">
                            <thead>
                                <tr>
                                    <th class="form-group">
                                        <p>色</p>
                                    </th>
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
                                    <td>
                                        <select name="color-{{ $i }}" class="label-color-select">
                                            <option class="color-label" value=""></option>
                                            <option class="color-label pink" value="pink" {{ old('color') == "pink" ? "selected" : null }}>ピンク</option>
                                            <option class="color-label purple" value="purple" {{ old('color') == "purple" ? "selected" : null }}>紫</option>
                                            <option class="color-label blue" value="blue" {{ old('color') == "blue" ? "selected" : null }}>青</option>
                                            <option class="color-label aqua" value="aqua" {{ old('color') == "aqua" ? "selected" : null }}>水色</option>
                                            <option class="color-label green" value="green" {{ old('color') == "green" ? "selected" : null }}>緑</option>
                                            <option class="color-label yellow" value="yellow" {{ old('color') == "yellow" ? "selected" : null }}>黄色</option>
                                            <option class="color-label orange" value="orange" {{ old('color') == "orange" ? "selected" : null }}>オレンジ</option>
                                        </select>
                                    </td>                               
                                    <td class="form-group ingredient-name">
                                        <input type="text" name="ingredient-{{ $i }}" class="form-control" placeholder="（例）人参" value="{{ old('ingredient') }}">
                                    </td>
                                    <td class="form-group ideal-amount">
                                        <input type="text" name="ideal-amount-{{ $i }}" class="form-control" placeholder="（例）2本"  value="{{ old('ideal-amount') }}">
                                    </td>
                                    <td class="form-group real-amount">
                                        <div class="form-control d-flex">
                                            <div>
                                                <input type="radio" id="real-left-{{ $i }}" name="real-amount-{{ $i }}" class="zero" value="0" {{ old('real-amount-' .$i ) == "0" ? "checked" : null }}>
                                                <label class="radio-left" for="real-left-{{ $i }}">ない</label>                                            
                                            </div>
                                            <div>
                                                <input type="radio" id="real-center-{{ $i }}" name="real-amount-{{ $i }}" class="one" value="1" {{ old('real-amount-' .$i ) == "1" ? "checked" : null }}>
                                                <label class="radio-center" for="real-center-{{ $i }}">少ない</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="real-right-{{ $i }}" name="real-amount-{{ $i }}" class="two" value="2" {{ old('real-amount-' .$i ) == "2" ? "checked" : null }}>                                            
                                                <label class="radio-right" for="real-right-{{ $i }}">多い</label>
                                            </div>                                            
                                        </div>
                                    </td>
                                    <td class="form-group waste-amount">
                                        <div class="form-control d-flex">
                                            <div>
                                                <input type="radio" id="waste-left-{{ $i }}"name="waste-amount-{{ $i }}" value="1" {{ old('waste-amount-' .$i ) == "1" ? "checked" : null }}>
                                                <label class="radio-left" for="waste-left-{{ $i }}">少ない</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="waste-right-{{ $i }}"name="waste-amount-{{ $i }}" value="2" {{ old('waste-amount-' .$i ) == "2" ? "checked" : null }}>
                                                <label class="radio-right" for="waste-right-{{ $i }}">多い</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="form-group restock-amount">
                                        <input type="text" name="restock-amount-{{ $i }}" class="form-control" value="{{ old('restock-amount-' . $i ) }}">
                                    </td>
                                    <td class="form-group delete-record">
                                        <button type="button" class="btn btn-danger delete-Btn mt-3" id="deleteBtn-{{ $i }}" data-id="{{ $i }}">削除</button>
                                    </td>                                
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success" id="addRecordBtn">追加</button>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="record-submit-btn">登録</button>
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