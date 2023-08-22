// -------------------------
// プレビュー機能
// -------------------------
document.addEventListener('DOMContentLoaded', function(){
  // 1.プレビュー画像を表示する場所(div)を取得
    const previewImage = document.getElementById('previewImage');

  // 対象がなければ、何もしない（プレビュー機能から抜ける）
    if (!previewImage) { return false;}

  // 2.プレビュー画面を消去する関数
    function clearPreviewImage() {
        const previewImage = document.getElementById('previewImage');
        while (previewImage.firstChild) {
            previewImage.removeChild(previewImage.firstChild);
        }
    }

  // 3.画像ファイルが選択されたら処理実行
    document.getElementById('image').addEventListener('change', function(e){
        const file = e.target.files[0];

        // fileオブジェクトをURLに変換させる処理
        const blob = window.URL.createObjectURL(file);

        // 古いプレビュー画像を削除
        clearPreviewImage();

        // 新しいプレビュー画像を作成
        // 4.divタグ・imgタグを作成、クラス・属性を付与
        const imageElement =  document.createElement('div');
        const blobImage = document.createElement('img');
        blobImage.setAttribute('src', blob);
        blobImage.classList.add('preview-size');

        // 5.親子紐づけ
        imageElement.appendChild(blobImage);
        previewImage.appendChild(imageElement);
    });
});


// -------------------------
// クリアボタン
// -------------------------
// クリアボタン取得
let clearIngredientBtns = document.querySelectorAll('.clearIngredientBtn');
let clearProcessBtns = document.querySelectorAll('.clearProcessBtn');

// クリア関数
let clearElement = (el)=>{
    el.value = '';
};

// ボタンにクリア関数付与する関数
function setClearBtn(btnObjs,firstColumn, secondColumn ){
    btnObjs.forEach((btn) => {
        btn.addEventListener('click', ()=>{
            let id = btn.dataset.id;
            let firstColumnInput = document.getElementById(firstColumn + '-' + id);
            let secondColumnInput = document.getElementById(secondColumn + '-' + id); 
            
            clearElement(firstColumnInput);
            clearElement(secondColumnInput);
        });
    });
};

setClearBtn(clearIngredientBtns, 'ingredient', 'amount');
setClearBtn(clearProcessBtns, 'process', 'detail');

// --------------------------------------------
// レシピ登録画面：入力項目の表示・非表示切替
// --------------------------------------------

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

    // 項目追加ボタンを設定する関数
    function setupAddBtn(btnObj, objs, objsLength){
        if(btnObj){
            btnObj.addEventListener('click', ()=> {
                let openedObjs = Array.from(objs).filter(tr => tr.style.display=='');
                let openedLength = openedObjs.length;

                if(openedLength < objsLength ){
                    let tr = objs[openedLength];
                    openElement(tr);
                }

                if(openedLength +1 == objsLength){
                    closeElement(btnObj);
                }
            });
        }
    }

// ボタンの引数取得・関数にセット
// -------------------------
    // 食材追加ボタン
    let addIngredientBtn = document.getElementById('addIngredientBtn');
    let ingredients = document.querySelectorAll('.ingredient');
    let ingredientsLength = ingredients.length;
    setupAddBtn(addIngredientBtn, ingredients, ingredientsLength);

    // 手順追加ボタン
    let addProcessBtn = document.getElementById('addProcessBtn');
    let processes = document.querySelectorAll('.process');
    let processesLength = processes.length;
    setupAddBtn(addProcessBtn, processes, processesLength);


// -------------------------
// ラベル色変更
// -------------------------
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

// --------------------------------------------
// 食材在庫登録画面：入力項目の追加・削除
// --------------------------------------------
const addRecordBtn = document.getElementById('addRecordBtn');
const recordsContainer = document.getElementById('records-container');
let recordIndex = document.querySelectorAll('.food-record').length + 1;

const createRecordRow = (index) => {
    const newRow = document.createElement('tr');
    newRow.id = 'food-record-' + recordIndex;
    newRow.className = 'food-record';

    // 新しい行の内容を設定
    newRow.innerHTML = `
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
            <input type="text" name="ideal-amount-${recordIndex}" class="form-control" placeholder="（例）2本"  value="">
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
                    <input type="radio" id="waste-left-${recordIndex}" name="waste-amount-${recordIndex}" value="1" {{ old('waste-amount-' .${recordIndex} ) == "1" ? "checked" : null }}>
                    <label class="radio-left" for="waste-left-${recordIndex}">少ない</label>
                </div>
                <div>
                    <input type="radio" id="waste-right-${recordIndex}" name="waste-amount-${recordIndex}" value="2" {{ old('waste-amount-' .${recordIndex} ) == "2" ? "checked" : null }}>
                    <label class="radio-right" for="waste-right-${recordIndex}">多い</label>
                </div>
            </div>
        </td>
        <td class="form-group restock-amount">
            <input type="text" name="restock-amount-${recordIndex}" class="form-control" placeholder="（例）2本"  value="{{ old('restock-amount-'.${recordIndex} ) }}">
        </td>
        <td class="form-group delete-record">
            <button type="button" class="btn btn-danger delete-Btn mt-3" id="deleteBtn-${recordIndex}" data-id="${recordIndex}">削除</button>
        </td>`;

    return newRow;
};

// 関数を作成して削除ボタンのイベントを設定
function setupDeleteBtn(deleteBtn) {
    deleteBtn.addEventListener('click', () => {
        let id = deleteBtn.dataset.id;
        deleteRow = document.getElementById('food-record-' + id);
        recordsContainer.removeChild(deleteRow);
        recordIndex--;

        if(addRecordBtn.style.display="none"){
            openElement(addRecordBtn);
        }
    });
}

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

// 初期の削除ボタンにイベントを設定
const deleteRecordBtns = document.querySelectorAll('.delete-Btn');
deleteRecordBtns.forEach(deleteRecordBtn => {
    setupDeleteBtn(deleteRecordBtn);
});


// -------------------------
// ページ一番上にスクロールする機能
// -------------------------
function scrollToTop() {
    window.scrollTo(0, 0);
}

// -------------------------
// ページ一番下にスクロールする機能
// -------------------------
function scrollToBottom() {
    window.scrollTo(0, document.body.scrollHeight);
}

// -------------------------
// 補充数量を反映する機能
// -------------------------
let exeBtn = document.getElementById('exe-btn');

exeBtn.addEventListener('click', () => {
    let rows = document.querySelectorAll('.food-record');

    rows.forEach((row, index) => {
        let realAmountRadios = row.querySelectorAll('.real-amount input[type="radio"]');
        let restockAmountInput = row.querySelector('.restock-amount input[type="text"]');
        let idealAmountInput = row.querySelector('.ideal-amount input[type="text"]');
        
        realAmountRadios.forEach(radio => {
            if (radio.checked && (radio.value === "0" || radio.value === "1")) {
                restockAmountInput.value = idealAmountInput.value;
            }
        });
    });
});


// -------------------------
// ラベル色で並び替え
// -------------------------
// 並び替えボタンの要素を取得
const sortButton = document.getElementById('sort-button');

// 並び替えボタンがクリックされたときの処理
sortButton.addEventListener('click', () => {
    // 各行を色ごとにグループ化
    const colorGroups = {};
    foodRecords.forEach((foodRecord) => {
        const colorClass = foodRecord.querySelector('.label-color-select').value;
        if (!colorGroups[colorClass]) {
            colorGroups[colorClass] = [];
        }
        colorGroups[colorClass].push(foodRecord);
    });

    // 各色グループを並び替え
    const sortedFoodRecords = [];
    ['pink', 'purple', 'blue', 'aqua', 'green', 'yellow', 'orange'].forEach((color) => {
        if (colorGroups[color]) {
            sortedFoodRecords.push(...colorGroups[color]);
        }
    });

    // 並び替えた要素をコンテナに追加
    sortedFoodRecords.forEach((foodRecord) => {
        recordsContainer.appendChild(foodRecord);
    });
});

// const form = document.getElementById('record-form');
// const submitButton = document.getElementById('record-submit-btn');

// submitButton.addEventListener('click', function(event) {
//     // データを保持する配列を定義
//     const data = [];

//     // 各行のデータを配列に格納
//     recordsContainer.querySelectorAll('.food-record').forEach(row => {
//         const recordId = row.dataset.recordID;
//         const rowData = {
//             color: row.querySelector('[name="color-${ recordId }"]').value,
//             ingredient: row.querySelector('[name="ingredient-${ recordId }"]').value,
//             idealAmount: row.querySelector('[name="ideal-amount-${ recordId }"]').value,
//             realAmount: row.querySelector('[name="real-amount-${ recordId }"]').value,
//             wasteAmount: row.querySelector('[name="waste-amount-${ recordId }"]').value,
//             restockAmount: row.querySelector('[name="restock-amount-${ recordId }"]').value,
//             // 他のデータも同様に追加
//         };
//         data.push(rowData);
//     });

//     // データを並び替え
//     data.sort((a, b) => {
//         // 並び替えの条件をここに記述
//     });

//     // データを元にフォームの input 要素に値を設定
//     data.forEach((rowData, index) => {
//         const row = recordsContainer.querySelector(`[data-record-id="${index}"]`);
//         row.querySelector(`[name="color-${index}"]`).value = rowData.color;
//         row.querySelector(`[name="ingredient-${index}"]`).value = rowData.ingredient;
//         row.querySelector(`[name="ideal-amount-${index}"]`).value = rowData.idealAmount;
//         row.querySelector(`[name="real-amount-${index}"]`).value = rowData.realAmount;
//         row.querySelector(`[name="waste-amount-${index}"]`).value = rowData.wasteAmount;
//         row.querySelector(`[name="restock-amount-${index}"]`).value = rowData.restockAmount;
//     });

//     // // フォームを送信
//     // form.submit();
// });