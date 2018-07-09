<?php
$host = "localhost";
$username = "test";
$password = "test";
$dbname = "register_func";

$mysqli = new mysqli($host, $username, $password, $dbname);
if ($mysqli->connect_error) {
	error_log($mysqli->connect_error);
	exit;
}
?>

<?php
ob_start();
session_start();
if( isset($_SESSION['user']) != "") {
	header("Location: home.php");
}
?>

<?php
if(isset($_POST['login'])) {
	$username = $mysqli->real_escape_string($_POST['username']);
	$password = $mysqli->real_escape_string($_POST['password']);

	$query = "SELECT * FROM users WHERE username='$username'";
	$result = $mysqli->query($query);
	if (!$result) {
		print('クエリーが失敗しました。' . $mysqli->error);
		$mysqli->close();
		exit();
	}

	while ($row = $result->fetch_assoc()) {
		$db_hashed_pwd = $row['password'];
		$user_id = $row['user_id'];
	}

	$result->close();

	if (password_verify($password, $db_hashed_pwd)) {
		$_SESSION['user'] = $user_id;
		header("Location: home.php");
		exit;
	} else { ?>
		<div class="alert alert-danger" role="alert">ユーザー名とパスワードが一致しません。</div>
	<?php }
}

if(isset($_POST['signup'])) {
	header("Location: register.php");
} ?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>日本一周体験システム</title>
<link rel="stylesheet" href="style.css">
</head>
</head>
<body>
<div class="col-xs-6 col-xs-offset-3">

<form method="post">
	<h1>ログイン画面</h1>
	<div class="form-group">
		<input type="username"  class="form-control" name="username" placeholder="ユーザー名" required />
	</div>
	<div class="form-group">
		<input type="password" class="form-control" name="password" placeholder="パスワード" required />
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
