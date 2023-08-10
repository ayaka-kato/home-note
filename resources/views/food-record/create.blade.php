@extends('adminlte::page')

@section('title', '食材在庫データ登録')

@section('content_header')
    <h1>食材在庫データ登録</h1>
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
                <form method="POST">
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < 50; $i++)
                            @if($i > 10)
                            <tr id="food-record-{{ $i }}" style="display:none">
                            @else
                            <tr id="food-record-{{ $i }}">                              
                                <td class="form-group">
                                    <div>
                                        <input type="text" id="myInput-{{ $i }}" onkeyup="searchFood()" placeholder="食材を検索する">
                                        <div id="mySelect">
                                            @foreach($foods as $food)
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" value="{{ $food->id }}" class="food-checkbox" id="food-checkbox-{{ $food->id }}">
                                                <label for="food-checkbox-{{ $food->id }}">{{ $food->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                                <td class="form-group">
                                    <input type="text" class="form-control" id="ideal-amount-{{ $i }}" name="type" placeholder="（例）2本">
                                </td>
                                <td class="form-group">
                                    <div class="form-control">
                                        <input type="radio" name="real-amount-{{ $i }}" value="0">ない
                                        <input type="radio" name="real-amount-{{ $i }}" value="1">少ない
                                        <input type="radio" name="real-amount-{{ $i }}" value="2">多い
                                    </div>
                                </td>
                                <td class="form-group">
                                    <div class="form-control">
                                        <input type="radio" name="waste-amount-{{ $i }}" value="0">ない
                                        <input type="radio" name="waste-amount-{{ $i }}" value="1">少ない
                                        <input type="radio" name="waste-amount-{{ $i }}" value="2">多い
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex form-group">
                                        <button type="button" class="btn btn-danger delete-Btn mt-3" id="deleteBtn-{{ $i }}" data-id="{{ $i }}">削除</button>
                                    </div>
                                </td>                                
                            </tr>
                            @endif
                            @endfor
                        </tbody>
                    </table>

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

<script>
function searchFood() {
    var input, filter, checkboxes, i, label, txtValue;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    checkboxes = document.querySelectorAll(".food-checkbox");

    for (i = 0; i < checkboxes.length; i++) {
        label = checkboxes[i].nextElementSibling; // 隣接する<label>要素を取得
        txtValue = label.textContent || label.innerText;

        // 各食材のIDを取得
        var foodId = checkboxes[i].value;

        // 対応する食材の検索結果を管理するための要素を取得
        var foodCheckboxElement = document.getElementById('food-checkbox-' + foodId);

        // 検索テキストと一致するか判定し、表示・非表示を設定
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            foodCheckboxElement.parentNode.style.display = "block";
        } else {
            foodCheckboxElement.parentNode.style.display = "none";
        }
    }
}
</script>
@section('js')
@stop