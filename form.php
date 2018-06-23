<?php

$dbname = "mysql:host=localhost;dbname=g031o070;charset=utf8";  //データベース、書式の設定
$usrname = "test";  //ユーザー名
$paword = "test";  //パスワード

try{
  $db = new PDO($dbname, $usrname, $paword, array(PDO::ATTR_EMULATE_PREPARES => false));  //データベースに接続、型変換の回避
} catch (PDOException $e) {
  exit('データベース接続失敗。'.$e->getMessage()); //データベースに繋がらない場合のエラーメッセージ
}

?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>レコード登録</title>
</head>
<body>
  <form action="record.php" method="post">
    ユーザー名：<input type="text" name="user_name" size="10" value="" /><br />
    パスワード：<input type="text" name="user_password" size="10" value="" /><br />
    <br />
    <input type="submit" value="追加する" />
  </form>
</body>
</html>
