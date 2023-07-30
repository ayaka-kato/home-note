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

// 1.処理：きっかけとなる対象を取得
let addBtns = document.querySelectorAll('.add-Btn');
let deleteBtns = document.querySelectorAll('.delete-Btn');

// 2.処理：styleのdisplayを変更する関数の設定
let openElement = (el)=> {
    if(el.style.display=='none'){
        el.style.display='';
    }
}

let closeElement = (el)=>{
    if(el.style.display==''){
    el.style.display='none'; 
    }
}

let clearElement = (el) => {
    if (el !== null){
    el.value = '';
    }
}

// 追加ボタン
// 3.ループ処理：
addBtns.forEach(function(addBtn){

    // 3-1.発火設定
    addBtn.addEventListener('click', ()=>{

        // 3-2.処理：次のidを設定する
        let add_id = Number(addBtn.dataset.id) + 1;

        // 3-3.処理：表示・非表示を切り替える要素を取得
        let div = document.getElementById('addForm-'+add_id);

        // 3-4.処理：ボタンに処理を付与する
        closeElement(addBtn);
        openElement(div);

    }, false);
});

// 削除ボタン
deleteBtns.forEach(function(deleteBtn){

    deleteBtn.addEventListener('click', ()=>{

        let delete_id = Number(deleteBtn.dataset.id) ;

        // 入力していたデータの消去処理
        var headingInput = document.getElementById('heading' + delete_id);
        var detailInput = document.getElementById('detail-' + delete_id);

        clearElement(headingInput);
        clearElement(detailInput);

        let div = document.getElementById('addForm-'+delete_id);
        let addBtn = document.getElementById('addBtn-'+ Number(delete_id-1));

        // ボタンの表示・非表示
        closeElement(div);   
        openElement(addBtn);   
    }, false);
});




