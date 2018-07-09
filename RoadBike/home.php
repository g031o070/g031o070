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
session_start();
if(!isset($_SESSION['user'])) {
	header("Location: index.php");
}

$query = "SELECT * FROM users WHERE user_id=".$_SESSION['user']."";
$result = $mysqli->query($query);
$result = $mysqli->query($query);
if (!$result) {
	print('クエリーが失敗しました。' . $mysqli->error);
	$mysqli->close();
	exit();
}

while ($row = $result->fetch_assoc()) {
	$id = $row['user_id'];
	$username = $row['username'];
}

$result->close();
?>

<?php
if(isset($_POST['register'])) {
	header("Location: training.php");
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
<h1>ホーム画面</h1>
<ul>
	<li>番号：<?php echo $id; ?></li>
	<li>ユーザー名：<?php echo $username; ?></li>
</ul>
<div class="form-group">
	<button type="submit" class="btn btn-default" name="register">トレーニング登録</button>
</div>
<a href="logout.php?logout">ログアウト</a>
</form>

</div>
</body>
</html>
