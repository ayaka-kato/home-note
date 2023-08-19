// -------------------------
// プレビュー機能
// -------------------------
document.addEventListener('DOMContentLoaded', function(){

  // 1.プレビュー画像を表示する場所(div)を取得
    const previewImage = document.getElementById('previewImage');

  // 対象がなければ、何もしない（プレビュー機能から抜ける）
    if (!previewImage) { return false;}

  // --------------------------------------------------

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
        <td class="form-group ingredient-name">
            <input type="text" name="ingredient-${recordIndex}" class="form-control" placeholder="（例）人参" value="">
        </td>
        <td class="form-group ideal-amount">
            <input type="text" name="ideal-amount-${recordIndex}" class="form-control" placeholder="（例）2本"  value="">
        </td>
        <td class="form-group real-amount">
            <div class="form-control">
                <input type="radio" name="real-amount-${recordIndex}" value="0" {{ old('real-amount-' .${recordIndex} ) == "0" ? "checked" : null }}>ない
                <input type="radio" name="real-amount-${recordIndex}" value="1" {{ old('real-amount-' .${recordIndex} ) == "1" ? "checked" : null }}>少ない
                <input type="radio" name="real-amount-${recordIndex}" value="2" {{ old('real-amount-' .${recordIndex} ) == "2" ? "checked" : null }}>多い
            </div>
        </td>
        <td class="form-group waste-amount">
            <div class="form-control">
                <input type="radio" name="waste-amount-${recordIndex}" value="1" {{ old('waste-amount-' .${recordIndex} ) == "1" ? "checked" : null }}>少ない
                <input type="radio" name="waste-amount-${recordIndex}" value="2" {{ old('waste-amount-' .${recordIndex} ) == "2" ? "checked" : null }}>多い
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

    // 新しい行に対応する削除ボタンを取得してイベントを設定
    const newDeleteBtn = newRow.querySelector('.delete-Btn');
    setupDeleteBtn(newDeleteBtn);
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

// // -------------------------
// // 買い物リスト送信確認機能
// // -------------------------
// let shoppingListBtn = document.getElementById('shopping-list-btn');
// let modalBody = document.getElementById('modal-body');

// shoppingListBtn.addEventListener('click', () => {
//     modalBody.innerHTML = '';
//     let rows = document.querySelectorAll('.food-record');
//     console.log(rows);

//     rows.forEach((row, index) => {
//         let ingredientInput = row.querySelector('.ingredient input[type="text"]').value;
//         let restockAmountInput = row.querySelector('.restock-amount input[type="text"]').value;


//         let div = document.createElement(div);
//         div.innerHTML = `
//             <span>${ ingredientInput }</span>
//             <span>${ restockAmountInput }</span>
//         `;
    
//         modalBody.appendChild(div);
//     });
// });