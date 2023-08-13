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
// 入力項目の表示・非表示切替
// -------------------------

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
// 食材登録を続けるか確認するアラート機能
// -------------------------
function confirmSubmit(event) {
    event.preventDefault();
    if (confirm('続けて入力しますか？\n続けて入力する場合は、「OK」を押してください。\n\n続けて入力"しない"場合は、「キャンセル」を押してください。\n(食材登録後に一覧画面に移動します。)')) {
        document.getElementById('foodForm').submit();
    } else {
        document.getElementsByName('continue_input')[0].value = 0;
        document.getElementById('foodForm').submit();
    }
}

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

