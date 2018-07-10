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
$page_flag = 0; //入力画面

if (!empty($_POST['confirm'])) {
	$page_flag = 1; //確認画面

} elseif (!empty($_POST['submit'])) {
	$date = $mysqli->real_escape_string($_POST['date']);
  $speed = $mysqli->real_escape_string($_POST['speed']);
  $cadence = $mysqli->real_escape_string($_POST['cadence']);
  $distance = $mysqli->real_escape_string($_POST['distance']);
  $heartrate = $mysqli->real_escape_string($_POST['heartrate']);
  $time = $mysqli->real_escape_string($_POST['time']);
  $gear = $mysqli->real_escape_string($_POST['gear']);

  $query = "INSERT INTO training(user_id,date,speed,cadence,distance,heartrate,time,gear) VALUES('$id','$date','$speed','$cadence','$distance','$heartrate','$time','$gear')";
	if($mysqli->query($query)) {
		$page_flag = 2;  //完了画面
	} else { ?>
		<div class="alert alert-danger" role="alert">エラーが発生しました。</div>
		<?php
	}

} else {
	$page_flag = 0; //入力画面
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>日本一周体験システム</title>
</head>
<body>
	<?php if ($page_flag === 1) : ?>  <!--確認画面-->
		<form method="post">
			<div class="form-group">
				<label class="col-sm-3 control-label">日付：</label>
				<?php if (isset($_POST['date'])) {
					echo $_POST['date'];
				} ?>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">平均速度：</label>
				<?php if (isset($_POST['speed'])) {
					echo $_POST['speed'];
				} ?>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">平均ケイデンス：</label>
				<?php if (isset($_POST['cadence'])) {
					echo $_POST['cadence'];
				} ?>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">走行距離：</label>
				<?php if (isset($_POST['distance'])) {
					echo $_POST['distance'];
				} ?>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">心拍数：</label>
				<?php if (isset($_POST['heartrate'])) {
					echo $_POST['heartrate'];
				} ?>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">練習時間：</label>
				<?php if (isset($_POST['time'])) {
					echo $_POST['time'];
				} ?>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">ギア：</label>
				<?php if (isset($_POST['gear'])) {
					echo $_POST['gear'];
				} ?>
			</div>
			<p>この内容で登録してもよろしいでしょうか</p>
			<button class="btn btn-default" type="submit" name="back" value='back'>戻る</button>
			<button class="btn btn-default" type="submit" name="submit" value='submit'>登録</button>
			<input type="hidden" name="date" value="<?php echo $_POST['date'] ?>">
      <input type="hidden" name="speed" value="<?php echo $_POST['speed'] ?>">
      <input type="hidden" name="cadence" value="<?php echo $_POST['cadence'] ?>">
      <input type="hidden" name="distance" value="<?php echo $_POST['distance'] ?>">
      <input type="hidden" name="heartrate" value="<?php echo $_POST['heartrate'] ?>">
      <input type="hidden" name="time" value="<?php echo $_POST['time'] ?>">
      <input type="hidden" name="gear" value="<?php echo $_POST['gear'] ?>">
		</form>

	<?php elseif ($page_flag === 2) : ?>  <!--完了画面-->
		<h1>登録が完了しました</h1>
    <p>今日も練習お疲れさまでした。</p>
		<p>明日も練習頑張ってください。</p>
		<input class="btn btn-primary col-sm-4 col-sm-offset-4" type="button" onClick="location.href='home.php'" value="ホーム画面へ">

	<?php else : ?>  <!--登録画面-->
		<form method="post">
			<div class="form-group">
				<input class="form-control" type="date" name="date" placeholder="日付" value="<?php if(!empty($_POST['date'])){echo $_POST['date'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="speed" placeholder="平均速度" value="<?php if(!empty($_POST['speed'])){echo $_POST['speed'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="cadence" placeholder="平均ケイデンス" value="<?php if(!empty($_POST['cadence'])){echo $_POST['cadence'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="distance" placeholder="走行距離" value="<?php if(!empty($_POST['speed'])){echo $_POST['distance'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="heartrate" placeholder="心拍数" value="<?php if(!empty($_POST['heartrate'])){echo $_POST['heartrate'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="time" name="time" placeholder="練習時間" value="<?php if(!empty($_POST['time'])){echo $_POST['time'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="gear" placeholder="ギア" value="<?php if(!empty($_POST['gear'])){echo $_POST['gear'];} ?>">
			</div>
			<button class="btn btn-default" type="submit" name="confirm" value='cofirm'>確認</button>
		</form>
	<?php endif; ?>
</div>
</body>
</html>
