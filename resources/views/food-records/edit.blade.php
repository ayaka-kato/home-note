@extends('adminlte::page')

@section('title', 'ストックデータ編集')

@section('content_header')
    <h1>ストックデータ編集</h1>
    @if ($date)
    <p>登録日：{{ $date->date }}</p>
    @else
    <p>登録日：{{ $today }}</p>
    @endif
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
                @if ($date)
                <form method="POST" action="{{ route('updateRecord', [ 'date' => $date->id ] ) }}" id="record-form">
                @else
                <form method="POST" action="{{ route('storeRecord') }}" id="record-form">
                @endif
                    @csrf
                    <div class="card-body">
                    <!-- <button type="button" id="sort-button">色で並び替える</button> -->
                    <button type="button" id="exe-btn">補充数量に反映する</button>
                                        
                    <table class="table table-responsive table-hover text-nowrap record-table col-12">
                        <thead>
                            @if(session('message'))
                                <p>{{ session('message') }}</p>
                            @endif
                            <tr>
                                <th class="form-group"><p>食材<span class="need-mark">必須</span></p></th>
                                <th class="form-group"><p>理想在庫<span class="need-mark">必須</span></p></th>
                                <th class="form-group"><p>実在庫<span class="need-mark">必須</span></p></th>
                                <th class="form-group"><p>廃棄数</p></th>
                                <th class="form-group"><p>補充数量・コメント</p></th>
                                <th><p>色</p></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="records-container">
                            <!-- DBに登録がある場合 -->
                            @foreach($foodRecords as $index=>$foodRecord)
                            <tr id="food-record-{{ $index }}" class="food-record handle" data-id="{{ $index }}">                            
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
                                            <input type="radio" id="waste-left-{{ $index }}" name="waste-amount-{{ $index }}" value="0" {{ (old('waste-amount-' . $index) === "0" || $foodRecord->waste_amount === 1) ? "checked" : "" }}>
                                            <label class="radio-left" for="waste-left-{{ $index }}">ない</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="waste-center-{{ $index }}" name="waste-amount-{{ $index }}" value="1" {{ (old('waste-amount-' . $index) === "1" || $foodRecord->waste_amount === 1) ? "checked" : "" }}>
                                            <label class="radio-center" for="waste-center-{{ $index }}">少ない</label>
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
                                <td class="form-group delete-record">
                                    <button type="button" class="btn btn-danger delete-Btn" id="deleteBtn-{{ $index }}" data-id="{{ $index }}" onclick="return confirm('「捨てがち食材ランキング」のカウントが消去されますが、本当に削除していいですか？')">削除</button>
                                </td>
                                <td class="change-row-icon"><span class="border p-1 px-2">⇅</span></td>
                                <td><input type="hidden" name="order-{{ $index }}" value="{{ $index }}" id="order-{{ $index }}" class="order"></td>
                                <td><input type="hidden" name="dlt-frag-{{ $index }}" value="0" id="dlt-frag-{{ $index }}" class="dlt-frag"></td>                              
                            </tr>
                            @endforeach
                            <!-- 新規登録をする場合 -->

                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success my-2" id="addRecordBtn">追加</button>

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