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
if( isset($_SESSION['user']) != "") {  //ログイン済みならばホーム画面へ
	header("Location: home.php");
}
?>

<?php
if(isset($_POST['login'])) {  //loginがPOSTされたとき
	$username = $mysqli->real_escape_string($_POST['username']);  //データの受け取り、real_escape_string(SQLインジェクション対策)
	$password = $mysqli->real_escape_string($_POST['password']);

//クエリの実行
	$query = "SELECT * FROM users WHERE username='$username'";
	$result = $mysqli->query($query);
	if (!$result) {
		print('クエリーが失敗しました。' . $mysqli->error);
		$mysqli->close();
		exit();
	}

//ユーザーidとユーザー名を取り出す
	while ($row = $result->fetch_assoc()) {
		$db_hashed_pwd = $row['password'];
		$user_id = $row['user_id'];
	}

	$result->close();  //データベースの切断

//ハッシュ化されたパスワードがあっているか確認
	if (password_verify($password, $db_hashed_pwd)) {
		$_SESSION['user'] = $user_id;
		header("Location: home.php");  //ホーム画面
		exit;
	} else { ?>
		<div class="alert alert-danger" role="alert">ユーザー名とパスワードが一致しません。</div>
	<?php }
}

if(isset($_POST['signup'])) {  //signupがPOSTされたとき
	header("Location: users_register.php");  //新規登録画面
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
		<h1>ログイン画面</h1>
		<div class="form-group">
			<input type="username"  class="form-control" name="username" placeholder="ユーザー名" required>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" name="password" placeholder="パスワード" required>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-default" name="login">ログイン</button>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-default" name="signup">新規登録</button>
		</div>
	</form>
</div>
</body>
</html>
