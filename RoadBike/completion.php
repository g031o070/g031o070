<?php
if(isset($_POST['login'])) {
  header("Location: index.php");
}
?>


<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>登録完了画面</title>
<link rel="stylesheet" href="style.css">
</head>
</head>
<body>
<div class="col-xs-6 col-xs-offset-3">


<form method="post">
<h1>登録完了</h1>
<p>登録が完了しました。</p>
<p>下部ボタンからログイン画面に移動してください。</p>
<button type="submit" class="btn btn-default" name="login">ログイン画面へ</button>
</form>
</div>
</body>
</html>
