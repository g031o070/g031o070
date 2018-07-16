<?php
$host = "153.126.145.118";
$username = "g031o070";
$password = "g031o070";
$dbname = "g031o070";

$mysqli = new mysqli($host, $username, $password, $dbname);  //データベース接続
$mysqli->set_charset('utf8');  //文字コード指定
if ($mysqli->connect_error) {  //接続エラーのとき
	error_log($mysqli->connect_error);  //エラーメッセージ
	exit;  //終了
}
?>

<?php
session_start();  //セッション開始
if(!isset($_SESSION['user'])) { //未ログインならばログイン画面へリダイレクト
	header("Location: login.php");
}

//クエリの実行
$query = "SELECT * FROM users WHERE user_id=".$_SESSION['user']."";
$result = $mysqli->query($query);
if (!$result) {
	print('クエリーが失敗しました。' . $mysqli->error);
	$mysqli->close();
	exit();
}

//ユーザーidとユーザー名を取り出す
while ($row = $result->fetch_assoc()) {
	$id = $row['user_id'];
	$username = $row['username'];
}

$result->close();  //データベースの切断
?>

<?php
if(isset($_POST['register'])) {  //registerがPOSTされたとき
	header("Location: training_register.php");  //トレーニング登録画面
} ?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<title>日本一周体験システム</title>
</head>
<body>
	<form method="post">
		<h1>ホーム画面</h1>
		<ul>
			<li>ユーザー名：<?php echo $username; ?></li>
		</ul>
		<div class="form-group">
			<button type="submit" class="btn btn-default" name="register">トレーニング登録</button>
		</div>
		<a href="logout.php?logout">ログアウト</a>
	</form>
</body>
</html>
