<?php
$host = "153.126.145.118";
$username = "g031o070";
$password = "g031o070";
$dbname = "g031o070";

$mysqli = new mysqli($host, $username, $password, $dbname);
if ($mysqli->connect_error) {
	error_log($mysqli->connect_error);
	exit;
}
?>

<?php
session_start();
if(!isset($_SESSION['user'])) {
	header("Location: login.php");
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
	header("Location: training_register.php");
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
