// // ログイン・会員登録フォームの切替

//     // ラジオボタンの選択に応じて表示項目を切り替える
//     const loginFields = document.getElementById('login-fields');
//     const registerFields = document.querySelectorAll('.register-fields');
//     const loginHeader = document.getElementById('login-header');
//     const registerHeader = document.getElementById('register-header');
//     const radioButtons = document.querySelectorAll('input[name="action"]');

//     radioButtons.forEach(radio => {
//         radio.addEventListener('change', () => {
//             if (radio.value === 'login') {
//                 loginFields.style.display = 'block';
//                 loginHeader.style.display = 'block';
//                 registerHeader.style.display = 'none';
//                 registerFields.forEach(field => field.style.display = 'none');
//                 removeValidationAttributes(registerFields);
//             } else if (radio.value === 'register') {
//                 loginFields.style.display = 'none';
//                 loginHeader.style.display = 'none';
//                 registerHeader.style.display = 'block';
//                 registerFields.forEach(field => field.style.display = 'block');
//                 addValidationAttributes(registerFields);
//             }
//         });
//     });

//     // バリデーション属性を削除する関数
//     function removeValidationAttributes(formElements) {
//         formElements.forEach(formElement => {
//             const inputElements = formElement.querySelectorAll('input, textarea, select');
//             inputElements.forEach(input => {
//                 input.removeAttribute('required');
//                 input.removeAttribute('max');
//                 input.removeAttribute('min');
//                 input.removeAttribute('maxlength');
//                 input.removeAttribute('pattern');
//             });
//         });
//     }

    // // バリデーション属性を追加する関数
    // function addValidationAttributes(formElements) {
    //     formElements.forEach(formElement => {
    //         const inputElements = formElement.querySelectorAll('input, textarea, select');
    //         inputElements.forEach(input => {
    //             // 例えば、必須項目にする場合
    //             input.setAttribute('required', 'required');
    //         });
    //     });
    // }


// // フォームの送信処理をJSで行う（Ajaxを使用する場合）
// document.getElementById('loginForm').addEventListener('submit', function(event) {
//     event.preventDefault();
//     // ログインフォームの送信処理を記述（例：Ajaxリクエストを送信する）
//     // 例：Ajaxを使用してフォームを送信する場合
//     const form = document.getElementById('loginForm');
//     const formData = new FormData(form);
//     const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//     formData.append('_token', token);

//     fetch('{{ route('login-check') }}', {
//     method: 'POST',
//     body: formData,
// })
// .then(response => {
//   // レスポンスの処理
// })
// .catch(error => {
//   // エラーの処理
// });
// });

// document.getElementById('registerForm').addEventListener('submit', function(event) {
//     event.preventDefault();
//     // 会員登録フォームの送信処理を記述（例：Ajaxリクエストを送信する）
// });


// CSRFトークンを取得してフォームにセットする関数
function setCsrfToken() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "http://127.0.0.1:8000/login", true); // サーバーのCSRFトークン取得エンドポイントのURLを指定
  
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        const csrfToken = JSON.parse(xhr.responseText).csrfToken;
        document.getElementById("csrfToken").value = csrfToken;
      }
    };
  
    xhr.send();
  }
  
  // ログイン処理
  function login() {
    // フォームからemailとpasswordの値を取得
    const email = document.getElementById("email_1").value;
    const password = document.getElementById("password_1").value;
  
    // CSRFトークンを取得してフォームにセット
    setCsrfToken();
  
    // 送信するデータをオブジェクトにまとめる
    const data = {
      email: email,
      password: password,
      csrfToken: document.getElementById("csrfToken").value // CSRFトークンをリクエストに含める
    };
  
    // Ajaxリクエストを作成
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://127.0.0.1:8000/login", true); // サーバーのログインエンドポイントのURLを指定
    xhr.setRequestHeader("Content-Type", "application/json"); // リクエストのデータ形式をJSONに指定
  
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // ログイン成功の場合
          const response = JSON.parse(xhr.responseText);
          alert("ログイン成功: " + response.message);
        } else {
          // ログイン失敗の場合
          alert("ログイン失敗: " + xhr.responseText);
        }
      }
    };
  
    // リクエストを送信
    xhr.send(JSON.stringify(data));
  }
  