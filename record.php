<?php

$dbname = "mysql:host=153.126.145.118;dbname=g031o070;charset=utf8";  //データベース、書式の設定
$usrname = "g031o070";  //ユーザー名
$paword = "g031o070";  //パスワード

try{
  $db = new PDO($dbname, $usrname, $paword, array(PDO::ATTR_EMULATE_PREPARES => false));  //データベースに接続、型変換の回避

  $name = $_POST["user_name"];  //データの受け取り
  $password = $_POST["user_password"];  //データの受け取り

  if ((empty($name)) && (empty($password))) {    //ユーザー名もパスワードも入力されていないとき
    header("Location:form.php");  //form.phpに戻る
  }
  else if (empty($name)) {  //ユーザー名が入力されていないとき
    header("Location:form.php");  //form.phpに戻る
  }
  else if (empty($password)) {  //パスワードが入力されていないとき
    header("Location:form.php");  //form.phpに戻る
  }
  else {  //入力が全てO.K.のとき
    $stmt = $db -> prepare("INSERT INTO users (user_name, user_password) VALUES (:user_name, :user_password)");  //insert文

    //user_id(AUTO_INCREMENT)
    $stmt->bindParam(":user_name", $name, PDO::PARAM_STR);  //パラメータ、変数、型の指定
    $stmt->bindParam(":user_password", $password, PDO::PARAM_STR);  //パラメータ、変数、型の指定
    $stmt->execute();  //実行

    $qry = "SELECT * FROM users";  //userテーブルの全レコードを取得
    $data = $db -> query($qry);  //クエリの実行

    $db = null;  //データベースの切断
  }

  } catch (PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());  //データベースに繋がらない場合のエラーメッセージ
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>テーブル表示</title>
  <meta charset="utf-8">
</head>
<body>
  <h1>テーブル表示</h1>
  <table border='3'>
    <tr bgcolor="#6495ed">
      <th>ID</th>
      <th>名前</th>
      <th>パスワード</th>
      </tr>

    <?php
    //1行ずつ取り出し、データを表示
    while($value = $data->fetch(PDO::FETCH_ASSOC)) {
      $values[] = $value;
    }
      foreach($values as $value){
        ?>
        <tr>
      		<td><?php echo $value['user_id']; ?></td>
      		<td><?php echo htmlspecialchars($value['user_name'],ENT_QUOTES,'UTF-8'); ?></td>
          <td><?php echo htmlspecialchars($value['user_password'],ENT_QUOTES,'UTF-8'); ?></td>
      	</tr>
        <?php
      }
      ?>

  </table>
</body>
</html>
