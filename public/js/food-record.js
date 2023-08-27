// 共通して使用する関数の定義
// -------------------------
// 要素を表示する関数
let openElement = (el)=> {
    if(el.style.display=='none'){
        el.style.display='';
    }
}
// 要素を非表示にする関数
let closeElement = (el)=> {
    if(el.style.display==''){
        el.style.display='none';
    }
}


// --------------------------------------------
// 食材在庫登録画面：入力項目の追加・削除
// --------------------------------------------
const addRecordBtn = document.getElementById('addRecordBtn');
const recordsContainer = document.getElementById('records-container');
let recordIndex = document.querySelectorAll('.food-record').length;

const createRecordRow = (index) => {
    const newRow = document.createElement('tr');
    newRow.id = 'food-record-' + recordIndex;
    newRow.dataset.id = recordIndex;
    newRow.className = 'food-record';

    // 新しい行の内容を設定
    newRow.innerHTML = `
        <td><span class="border p-1 px-2">⇅</span></td>
        <td class="form-group">
            <select name="color-${recordIndex}" class="label-color-select">
                <option class="color-label" value="" {{ (old('color-' . ${recordIndex}) === "" ? "selected" : "" }}></option>
                <option class="color-label pink" value="pink" {{ (old('color-' . ${recordIndex}) === "pink" ? "selected" : "" }}>ピンク</option>
                <option class="color-label purple" value="purple" {{ (old('color-' . ${recordIndex}) === "purple" ? "selected" : "" }}>紫</option>
                <option class="color-label blue" value="blue" {{ (old('color-' . ${recordIndex}) === "blue" ? "selected" : "" }}>青</option>
                <option class="color-label aqua" value="aqua" {{ (old('color-' . ${recordIndex}) === "aqua" ? "selected" : "" }}>水色</option>
                <option class="color-label green" value="green" {{ (old('color-' . ${recordIndex}) === "green" ? "selected" : "" }}>緑</option>
                <option class="color-label yellow" value="yellow" {{ (old('color-' . ${recordIndex}) === "yellow" ? "selected" : "" }}>黄色</option>
                <option class="color-label orange" value="orange" {{ (old('color-' . ${recordIndex}) === "orange" ? "selected" : "" }}>オレンジ</option>
            </select>
        </td> 
        <td class="form-group ingredient-name">
            <input type="text" name="ingredient-${recordIndex}" class="form-control" placeholder="（例）人参" value="">
        </td>
        <td class="form-group ideal-amount">
            <input type="text" id="ideal-amount-${recordIndex}" name="ideal-amount-${recordIndex}" class="form-control" placeholder="（例）2本"  value="">
        </td>
        <td class="form-group real-amount">
            <div class="form-control d-flex">
                <div>
                    <input type="radio" id="real-left-${recordIndex}" name="real-amount-${recordIndex}" value="0" {{ old('real-amount-' .${recordIndex} ) == "0" ? "checked" : null }}>
                    <label class="radio-left" for="real-left-${recordIndex}">ない</label>
                </div>
                <div>
                    <input type="radio" id="real-center-${recordIndex}" name="real-amount-${recordIndex}" value="1" {{ old('real-amount-' .${recordIndex} ) == "1" ? "checked" : null }}>
                    <label class="radio-center" for="real-center-${recordIndex}">少ない</label>
                </div>
                <div>
                    <input type="radio" id="real-right-${recordIndex}" name="real-amount-${recordIndex}" value="2" {{ old('real-amount-' .${recordIndex} ) == "2" ? "checked" : null }}>
                    <label class="radio-right" for="real-right-${recordIndex}">多い</label>
                </div>
            </div>
        </td>
        <td class="form-group waste-amount">
            <div class="form-control d-flex">
                <div>
                    <input type="radio" id="waste-left-${recordIndex}" name="waste-amount-${recordIndex}" value="0" {{ old('waste-amount-' .${recordIndex} ) == "0" ? "checked" : null }}>
                    <label class="radio-left" for="waste-left-${recordIndex}">ない</label>
                </div>
                <div>
                    <input type="radio" id="waste-center-${recordIndex}" name="waste-amount-${recordIndex}" value="1" {{ old('waste-amount-' .${recordIndex} ) == "1" ? "checked" : null }}>
                    <label class="radio-center" for="waste-center-${recordIndex}">少ない</label>
                </div>
                <div>
                    <input type="radio" id="waste-right-${recordIndex}" name="waste-amount-${recordIndex}" value="2" {{ old('waste-amount-' .${recordIndex} ) == "2" ? "checked" : null }}>
                    <label class="radio-right" for="waste-right-${recordIndex}">多い</label>
                </div>
            </div>
        </td>
        <td class="form-group restock-amount">
            <input type="text" id="restock-amount-${recordIndex}" name="restock-amount-${recordIndex}" class="form-control"  {{ value != null ? value="old('restock-amount-${recordIndex}'): value="null" }}">
        </td>
        <td class="form-group delete-record">
            <button type="button" class="btn btn-danger delete-Btn mt-3" id="deleteBtn-${recordIndex}" data-id="${recordIndex}">削除</button>
        </td>
        <td><input type="hidden" name="order-${ recordIndex }" value="${ recordIndex }" id="order-${ recordIndex }" class="order"></td>  
        <td><input type="hidden" name="dlt-frag-${ recordIndex }}" value="0" id="dlt-frag-${ recordIndex }}" class="dlt-frag"></td>`;

    return newRow;
};

// 在庫データ追加ボタン
addRecordBtn.addEventListener('click', () => {
    const newRow = createRecordRow(recordIndex);
    recordsContainer.appendChild(newRow);
    recordIndex++;

    if (recordIndex > 50) {
        closeElement(addRecordBtn);
    }

    // 新しい行に対応する[削除ボタン]を取得してイベントを設定
    const newDeleteBtn = newRow.querySelector('.delete-Btn');
    setupDeleteBtn(newDeleteBtn);

    // 新しい行に対応する[セレクトボックスの変更]イベントを設定
    const newSelectColor = newRow.querySelector('.label-color-select');
    newSelectColor.addEventListener('change', () => {
        applyColorToFoodRecord(newSelectColor);
    });
});

// 関数を作成して削除ボタンのイベントを設定
function setupDeleteBtn(deleteBtn) {
    deleteBtn.addEventListener('click', () => {
        let id = deleteBtn.dataset.id;
        deleteRow = document.getElementById('food-record-' + id);

        // 削除するレコードのフラグを1(消去)に変え、非表示にする。
        deleteFrag = document.getElementById('dlt-frag-' + id);
        deleteFrag.value = 1;
        closeElement(deleteRow);

        // recordsContainer.removeChild(deleteRow);
        recordIndex--;

        if(addRecordBtn.style.display="none"){
            openElement(addRecordBtn);
        }
    });
}

// 初期の削除ボタンにイベントを設定
const deleteRecordBtns = document.querySelectorAll('.delete-Btn');
deleteRecordBtns.forEach(deleteRecordBtn => {
    setupDeleteBtn(deleteRecordBtn);
});


// ------------------------------------------------------------------------------------------------------------
// ラベル色変更
// ------------------------------------------------------------------------------------------------------------
// 関数で色を適用する処理を定義
function applyColorToFoodRecord(selectColor) {
    let selectedColor = selectColor.value; // 選択された色の値を取得
    let foodRecord = selectColor.closest('.food-record'); // 親要素の.food-recordを取得

    foodRecord.classList.remove('pink', 'purple', 'blue', 'aqua', 'green', 'yellow', 'orange'); // 一度すべての色のクラスを削除
    if (selectedColor !== '') {
        foodRecord.classList.add(selectedColor); // 選択された色のクラスを追加
    }
}

// セレクト要素と対象の行を取得
let selectColors = document.querySelectorAll('.label-color-select');
let foodRecords = document.querySelectorAll('.food-record');

// 初期の行に対して色を適用する
selectColors.forEach((selectColor, index) => {
    applyColorToFoodRecord(selectColor); // 初期表示時に色を適用
    selectColor.addEventListener('change', () => {
        applyColorToFoodRecord(selectColor); // セレクトボックスが変更されたときに色を適用
    });
});

// // ※edit.blade.phpのid="sort-button"はコメントアウト中（色別でも並び替えができるようになりたい）
// // -------------------------
// // ラベル色で並び替え
// // -------------------------
// // 並び替えボタンの要素を取得
// const sortButton = document.getElementById('sort-button');

// // 並び替えボタンがクリックされたときの処理
// sortButton.addEventListener('click', () => {
//     // 各行を色ごとにグループ化
//     const colorGroups = [];
//     foodRecords.forEach((foodRecord) => {
//         const colorClass = foodRecord.querySelector('.label-color-select').value;
//         if (!colorGroups[colorClass]) {
//             colorGroups[colorClass] = [];
//         }
//         colorGroups[colorClass].push(foodRecord);
//     });

//     // 各色グループを並び替え
//     const sortedFoodRecords = [];
//     ['pink', 'purple', 'blue', 'aqua', 'green', 'yellow', 'orange'].forEach((color) => {
//         if (colorGroups[color]) {
//             sortedFoodRecords.push(...colorGroups[color]);
//         }
//     });

//     // 並び替えた要素をコンテナに追加
//     sortedFoodRecords.forEach((foodRecord) => {
//         recordsContainer.appendChild(foodRecord);
//     });
// });

// ------------------------------------------------------------------------------------------------------------
// 補充数量を反映する機能
// ------------------------------------------------------------------------------------------------------------
let exeBtn = document.getElementById('exe-btn');

exeBtn.addEventListener('click', () => {
    let rows = document.querySelectorAll('.food-record');
    
    rows.forEach(row => {
        let id = row.dataset.id;
        let realAmountRadios = row.querySelectorAll('.real-amount input[type="radio"]');
        let restockAmountInput = document.getElementById('restock-amount-' + id);
        let idealAmountInput = document.getElementById('ideal-amount-' + id);

        realAmountRadios.forEach(radio => {
            if (radio.checked && (radio.value === "0" || radio.value === "1") ) {
                restockAmountInput.value = idealAmountInput.value;
            }
        });
    });
});