@extends('adminlte::page')

@section('title', '冷蔵庫チェックリスト編集')

@section('content_header')
    <h1>冷蔵庫チェックリスト編集</h1>
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
                <form method="POST" action="{{ route('updateRecord', [ 'date' => $date->id ] ) }}" id="record-form">
                    @csrf
                    <div class="card-body">
                    <!-- <button type="button" id="sort-button">色で並び替える</button> -->
                    <button type="button" id="exe-btn">補充数量に反映する</button>                    
                    <table class="table table-hover text-nowrap record-table col-12">
                        <thead>
                            @if(session('message'))
                                <p>{{ session('message') }}</p>
                            @endif
                            <tr>
                                <th><p>並び替え</p></th>
                                <th><p>色</p></th>
                                <th class="form-group"><p>食材</p></th>
                                <th class="form-group"><p>理想在庫</p></th>
                                <th class="form-group"><p>実在庫</p></th>
                                <th class="form-group"><p>廃棄数</p></th>
                                <th class="form-group"><p>補充数量・コメント</p></th>
                            </tr>
                        </thead>
                        <tbody id="records-container">
                            <!-- DBに登録がある場合 -->
                            @foreach($foodRecords as $index=>$foodRecord)
                            <tr id="food-record-{{ $index }}" class="food-record handle" data-id="{{ $index }}">
                                <td><img src="{{ asset('img/arrows-expand.svg') }}" alt="並び替えアイコン" class="border mt-2 p-2 "></td>  
                                <td class="form-group">
                                    <select name="color-{{ $index }}" class="label-color-select">
                                        <option class="color-label" value="" {{ (old('color-' . $index) === "" || $foodRecord->color === "") ? "selected" : "" }}></option>
                                        <option class="color-label pink" value="pink" {{ (old('color-' . $index) === "pink" || $foodRecord->color === "pink") ? "selected" : "" }}>ピンク</option>
                                        <option class="color-label purple" value="purple" {{ (old('color-' . $index) === "purple" || $foodRecord->color === "purple") ? "selected" : "" }}>紫</option>
                                        <option class="color-label blue" value="blue" {{ (old('color-' . $index) === "blue" || $foodRecord->color === "blue") ? "selected" : "" }}>青</option>
                                        <option class="color-label aqua" value="aqua" {{ (old('color-' . $index) === "aqua" || $foodRecord->color === "aqua") ? "selected" : "" }}>水色</option>
                                        <option class="color-label green" value="green" {{ (old('color-' . $index) === "green" || $foodRecord->color === "green") ? "selected" : "" }}>緑</option>
                                        <option class="color-label yellow" value="yellow" {{ (old('color-' . $index) === "yellow" || $foodRecord->color === "yellow") ? "selected" : "" }}>黄色</option>
                                        <option class="color-label orange" value="orange" {{ (old('color-' . $index) === "orange" || $foodRecord->color === "orange") ? "selected" : "" }}>オレンジ</option>
                                    </select>
                                </td>                             
                                <td class="form-group ingredient-name">
                                    <input type="text" name="ingredient-{{ $index }}" class="form-control" value="{{ old('ingredient-' . $index , $foodRecord->ingredient ) }}">
                                </td>
                                <td class="form-group ideal-amount">
                                    <input type="text" id="ideal-amount-{{ $index }}" name="ideal-amount-{{ $index }}" class="form-control" value="{{ old('ideal-amount-' . $index , $foodRecord->ideal_amount) }}">
                                </td>
                                <td class="form-group real-amount">
                                    <div class="form-control d-flex">
                                        <div>
                                            <input type="radio" id="real-left-{{ $index }}" name="real-amount-{{ $index }}" value="0" {{ (old('real-amount-' . $index) === "0" || $foodRecord->real_amount === 0) ? "checked" : "" }}>
                                            <label class="radio-left" for="real-left-{{ $index }}">ない</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="real-center-{{ $index }}" name="real-amount-{{ $index }}" value="1" {{ (old('real-amount-' . $index) === "1" || $foodRecord->real_amount === 1) ? "checked" : "" }}>
                                            <label class="radio-center" for="real-center-{{ $index }}">少ない</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="real-right-{{ $index }}" name="real-amount-{{ $index }}" value="2" {{ (old('real-amount-' . $index) === "2" || $foodRecord->real_amount === 2) ? "checked" : "" }}>
                                            <label class="radio-right" for="real-right-{{ $index }}">多い</label>
                                        </div>
                                    </div>
                                </td>
                                <td class="form-group waste-amount">
                                    <div class="form-control d-flex">
                                        <div>
                                            <input type="radio" id="waste-left-{{ $index }}" name="waste-amount-{{ $index }}" value="1" {{ (old('waste-amount-' . $index) === "1" || $foodRecord->waste_amount === 1) ? "checked" : "" }}>
                                            <label class="radio-left" for="waste-left-{{ $index }}">少ない</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="waste-right-{{ $index }}" name="waste-amount-{{ $index }}" value="2" {{ (old('waste-amount-' . $index) === "2" || $foodRecord->waste_amount === 2) ? "checked" : "" }}>
                                            <label class="radio-right" for="waste-right-{{ $index }}">多い</label>
                                        </div>
                                    </div>
                                </td>
                                <td class="form-group restock-amount">
                                    <input type="text" id="restock-amount-{{ $index }}" name="restock-amount-{{ $index }}" class="form-control" value="{{ old('restock-amount-' . $index , $foodRecord->restock_amount) }}">
                                </td>
                                <td class="form-group delete-record">
                                    <button type="button" class="btn btn-danger delete-Btn mt-3" id="deleteBtn-{{ $index }}" data-id="{{ $index }}">削除</button>
                                </td>
                                <td><input type="hidden" name="order-{{ $index }}" value="{{ $index }}" id="order-{{ $index }}" class="order"></td>
                                <td><input type="hidden" name="dlt-frag-{{ $index }}" value="0" id="dlt-frag-{{ $index }}" class="dlt-frag"></td>                              
                            </tr>
                            @endforeach
                            <!-- 新規登録をする場合 -->

                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success" id="addRecordBtn">追加</button>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="{{ asset('js/food-record.js') }}"></script>
@stop