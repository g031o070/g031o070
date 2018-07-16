<?php
if(isset($_POST['login'])) {  //loginがPOSTされたとき
  header("Location: login.php");  //ログイン画面
}
?>

<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8" />
  <title>日本一周体験システム</title>
</head>
<body>
  <form method="post">
    <h1>登録完了</h1>
    <p>登録が完了しました。</p>
    <p>下部ボタンからログイン画面に移動してください。</p>
    <button type="submit" class="btn btn-default" name="login">ログイン画面へ</button>
  </form>
</body>
</html>
