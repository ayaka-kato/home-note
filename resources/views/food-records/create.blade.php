@extends('adminlte::page')

@section('title', 'ストックデータ登録')

@section('content_header')
    <h1>ストックデータ登録</h1>
    <p>登録日：{{ Carbon\Carbon::now()->format('Y-m-d') }}</p>
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
                <form method="POST" action="{{ route('storeRecord') }}" id="record-form">
                    @csrf
                    <div class="card-body">
                        <!-- <button type="button" id="sort-button">並び替える</button> -->
                        <button type="button" id="exe-btn">補充数量に反映する</button>
                        <table class="table table-responsive table-hover text-nowrap record-table">
                            <thead>
                                <tr>
                                    <th class="form-group col-2"><p>食材<span class="need-mark">必須</span></p></th>
                                    <th class="form-group col-2"><p>理想在庫<span class="need-mark">必須</span></p></th>
                                    <th class="form-group col-2"><p>実在庫<span class="need-mark">必須</span></p></th>
                                    <th class="form-group col-2"><p>廃棄数</p></th>
                                    <th class="form-group col-2"><p>補充数量・コメント</p></th>
                                    <th class="form-group col-1"><p>色</p></th>
                                    <th class="col-1"></th>
                                </tr>
                            </thead>
                            <tbody id="records-container">
                                @for($i = 0; $i < 5; $i++)
                                <tr id="food-record-{{ $i }}" class="food-record handle" data-id="{{ $i }}">                             
                                    <td class="form-group ingredient-name col-2">
                                        <input type="text" name="ingredient-{{ $i }}" class="form-control" placeholder="（例）人参" value="{{ old('ingredient') }}">
                                    </td>
                                    <td class="form-group ideal-amount col-2">
                                        <input type="text" id="ideal-amount-{{ $i }}" name="ideal-amount-{{ $i }}" class="form-control" placeholder="（例）2本"  value="{{ old('ideal-amount') }}">
                                    </td>
                                    <td class="form-group real-amount col-2">
                                        <div class="form-control d-flex">
                                            <div>
                                                <input type="radio" id="real-left-{{ $i }}" name="real-amount-{{ $i }}" value="0" {{ old('real-amount-' .$i ) == "0" ? "checked" : null }}>
                                                <label class="radio-left" for="real-left-{{ $i }}">ない</label>                                            
                                            </div>
                                            <div>
                                                <input type="radio" id="real-center-{{ $i }}" name="real-amount-{{ $i }}" value="1" {{ old('real-amount-' .$i ) == "1" ? "checked" : null }}>
                                                <label class="radio-center" for="real-center-{{ $i }}">少ない</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="real-right-{{ $i }}" name="real-amount-{{ $i }}" value="2" {{ old('real-amount-' .$i ) == "2" ? "checked" : null }}>                                            
                                                <label class="radio-right" for="real-right-{{ $i }}">多い</label>
                                            </div>                                            
                                        </div>
                                    </td>
                                    <td class="form-group waste-amount col-2">
                                        <div class="form-control d-flex">
                                            <div>
                                                <input type="radio" id="waste-left-{{ $i }}"name="waste-amount-{{ $i }}" value="0" {{ old('waste-amount-' .$i ) == "0" ? "checked" : null }}>
                                                <label class="radio-left" for="waste-left-{{ $i }}">ない</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="waste-center-{{ $i }}"name="waste-amount-{{ $i }}" value="1" {{ old('waste-amount-' .$i ) == "1" ? "checked" : null }}>
                                                <label class="radio-center" for="waste-center-{{ $i }}">少ない</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="waste-right-{{ $i }}"name="waste-amount-{{ $i }}" value="2" {{ old('waste-amount-' .$i ) == "2" ? "checked" : null }}>
                                                <label class="radio-right" for="waste-right-{{ $i }}">多い</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="form-group restock-amount col-2">
                                        <input type="text" id="restock-amount-{{ $i }}" name="restock-amount-{{ $i }}" class="form-control" value="{{ old('restock-amount-' . $i ) }}">
                                    </td>
                                    <td class="col-1">
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
                                    <td class="form-group delete-record col-1">
                                        <button type="button" class="btn btn-danger delete-Btn" id="deleteBtn-{{ $i }}" data-id="{{ $i }}">削除</button>
                                    </td>
                                    <td class="change-row-icon"><span class="border p-1 px-2">⇅</span></td> 
                                    <td><input type="hidden" name="order-{{ $i }}" value="{{ $i }}" id="order-{{ $i }}" class="order"></td>
                                    <td><input type="hidden" name="dlt-frag-{{ $i }}" value="0" id="dlt-frag-{{ $i }}" class="dlt-frag"></td>                              
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success my-2" id="addRecordBtn">追加</button>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary m-auto col-4" id="record-submit-btn">登録</button>
                    </div>
                </form>
            </div>
            <div class="scroll-btn-area">
                <button onclick="scrollToBottom()" class="btn btn-scroll top"><img src="{{ asset('img/arrow-down-circle.svg') }}" alt="画面下へスクロールするアイコン"></button>
                <button onclick="scrollToTop()" class="btn btn-scroll bottom"><img src="{{ asset('img/arrow-up-circle.svg') }}" alt="画面上へスクロールするアイコン"></button>
                <p class="m-0 text-center">スクロールボタン</p>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="{{ asset('js/food-record.js') }}"></script>
<script>
// -----------------------------------------------------------------------------------------------------------
// ドラッグ＆ドロップ並び替え
// -----------------------------------------------------------------------------------------------------------
var el = document.getElementById('records-container');
var sortable = Sortable.create(el, {
    // ドラッグできる範囲の指定
    handle: '.handle',
    onSort: function(evt) {
        // 並び順が変わる度に順番を更新
        var items = evt.from.querySelectorAll('.food-record');
        for (var i = 0; i < items.length; i++) {
            // 表示順を更新する
            var item = items[i];
            item.querySelector('.order').value = i ;

            // 順番の値も更新する
            var index = Number(item.getAttribute('data-id')); 
            var hiddenInput = item.querySelector('input[name="order-' + index +'"]');
            hiddenInput.value = parseInt(i); // i を新しい順番として設定
        }
    },
    
    // -------------------------------------------------------------------
    // （二つのコードを一つにまとめたのが↑）
    // -------------------------------------------------------------------
    // onSort: function(evt) {

    //     // 表示順を更新する------------------------------------
    //     var items = evt.from.querySelectorAll('.food-record');
    //     for (var i = 0; i < items.length; i++) {
    //         items[i].querySelector('.order').value = i ;
    //     }

    //     // 順番の値を更新する----------------------------------
    //     // 並び替えた後の並び
    //     var order = sortable.toArray();

    //     // 最初の並び（index）の値をデータ属性から取得
    //     var index = Number(evt.item.getAttribute('data-id')); 
    //     var hiddenInput = document.querySelector('input[name="order-' + index +'"]');

    //     // 最初の並びの値を、並び替えた後に値に更新する
    //     hiddenInput.value = parseInt(order);
    // },
});
</script>
@stop