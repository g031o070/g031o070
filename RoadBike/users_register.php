<?php
$host = "153.126.145.118";
$username = "g031o070";
$password = "g031o070";
$dbname = "g031o070";

$mysqli = new mysqli($host, $username, $password, $dbname);  //データベース接続
$mysqli->set_charset('utf8');  //文字コード設定
if ($mysqli->connect_error) {  //接続エラーのとき
	error_log($mysqli->connect_error);  //エラーメッセージ
	exit;  //終了
}
?>

<?php
session_start();  //セッション開始
if( isset($_SESSION['user']) != "") {  //ログイン済みならばホーム画面へ
	header("Location: home.php");
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" />
<title>日本一周体験システム</title>
</head>
<body>

<?php
if(isset($_POST['signup'])) {  //signupがPOSTされたとき
	$username = $mysqli->real_escape_string($_POST['username']);  //データの受け取り、real_escape_string(SQLインジェクション対策)
	$password = $mysqli->real_escape_string($_POST['password']);
	$password_confirm = $mysqli->real_escape_string($_POST['password_confirm']);

//入力されたパスワードがあっているか確認
	if($password !== $password_confirm){ ?>
		<div class="alert alert-danger" role="alert">パスワードが一致しません</div>
	<?php	}
	else{
		$password = password_hash($password, PASSWORD_BCRYPT);  //パスワードをハッシュ化
		$query = "INSERT INTO users(username,password) VALUES('$username','$password')";  //POSTされたデータをデータベースへ
		if($mysqli->query($query)) {
			header("Location: users_completion.php");  //登録完了画面
		} else { ?>
			<div class="alert alert-danger" role="alert">エラーが発生しました。</div>
			<?php
		}
	}
}
?>

<form method="post">
	<h1>新規登録画面</h1>
	<div class="form-group">
		<input type="text" class="form-control" name="username" placeholder="ユーザー名" required>
	</div>
	<div class="form-group">
		<input type="password" class="form-control" name="password" placeholder="パスワード" required>
	</div>
	<div class="form-group">
		<input type="password" class="form-control" name="password_confirm" placeholder="パスワード（確認用）" required>
	</div>
	<button type="submit" class="btn btn-default" name="signup">登録</button>
</form>
</body>
</html>
