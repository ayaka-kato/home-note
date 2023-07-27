<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>D.TOKYO</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="style.js"></script>
</head>
<body>

        <h1>ログイン・会員登録</h1>
    
        <!-- ログインフォーム -->
        <form id="loginForm">
        @csrf
            <h2>ログイン</h2>
            <label for="loginEmail">メールアドレス:</label>
            <input type="text" id="loginEmail" name="email"><br>
        
            <label for="loginPassword">パスワード:</label>
            <input type="password" id="loginPassword" name="password"><br>
        
            <!-- CSRFトークンの隠しフィールド -->
            <input type="hidden" id="loginCsrfToken" name="csrfToken" value="">
        
            <button type="button" onclick="login()">ログイン</button>
        </form>
    
        <!-- 会員登録フォーム -->
        <form id="registerForm" >
        @csrf
            <h2>会員登録</h2>
            <label for="registerEmail">メールアドレス:</label>
            <input type="text" id="registerEmail" name="email"><br>
        
            <label for="registerPassword">パスワード:</label>
            <input type="password" id="registerPassword" name="password"><br>
        
            <!-- CSRFトークンの隠しフィールド -->
            <input type="hidden" id="registerCsrfToken" name="csrfToken" value="">
        
            <button type="button" onclick="register()">会員登録</button>
        </form>
    
        <script>
            // 初期表示ではログインフォームを表示
// ログインフォームの表示
function showLoginForm() {
  $("#loginForm").show();
  $("#registerForm").hide();
  setCsrfToken(); // CSRFトークンをセット
}

// 会員登録フォームの表示
function showRegisterForm() {
  $("#loginForm").hide();
  $("#registerForm").show();
  setCsrfToken(); // CSRFトークンをセット


// フォームのCSRFトークンを取得
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// トークンを表示して確認する（必要ならばAjaxリクエストにトークンを含めるなどの処理に使用）
console.log('CSRFトークン:', csrfToken);


// CSRFトークンを取得してフォームにセット
function setCsrfToken() {
  // サーバーサイドから取得したCSRFトークンをセットする処理を実装
   $("#loginCsrfToken").val(csrfToken);
  $("#registerCsrfToken").val(csrfToken);
}

// ログイン処理
function login() {
  // フォームからemailとpasswordの値を取得
  const email = $("#loginEmail").val();
  const password = $("#loginPassword").val();

  // CSRFトークンを取得してフォームにセット
  setCsrfToken();

  // 送信するデータをオブジェクトにまとめる
  const data = {
    email: email,
    password: password,
    csrfToken: $("#loginCsrfToken").val() // CSRFトークンをリクエストに含める
  };

  // Ajaxリクエストを送信し、ログイン処理を行う
  $.ajax({
    url: "/account/user", // ログインエンドポイントのURLを指定
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify(data),
    success: function (response) {
      // ログイン成功の場合
      alert("ログイン成功: " + response.message);

      // リダイレクト処理
      window.location.href = response.redirectURL; // リダイレクト先のURLに移動
    },
    error: function (xhr) {
      // ログイン失敗の場合
      alert("ログイン失敗: " + xhr.responseText);
    }
  });
}

// // 会員登録処理
// function register() {
//   // フォームからemailとpasswordの値を取得
//   const email = $("#registerEmail").val();
//   const password = $("#registerPassword").val();

//   //
// }

        </script>

</body>
</html>