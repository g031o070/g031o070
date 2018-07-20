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
if(!isset($_SESSION['user'])) {  //未ログインならばログイン画面へリダイレクト
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
$page_flag = 0; //入力画面

if (isset($_POST['confirm'])) {  //cofirmがPOSTされたとき
	$page_flag = 1; //確認画面

} elseif (isset($_POST['submit'])) {  //submitがPOSTされたとき
	$date = $mysqli->real_escape_string($_POST['date']);  //データの受け取り、real_escape_string(SQLインジェクション対策)
  $speed = $mysqli->real_escape_string($_POST['speed']);
  $cadence = $mysqli->real_escape_string($_POST['cadence']);
  $distance = $mysqli->real_escape_string($_POST['distance']);
  $heartrate = $mysqli->real_escape_string($_POST['heartrate']);
  $time = $mysqli->real_escape_string($_POST['time']);
  $gear = $mysqli->real_escape_string($_POST['gear']);

//POSTされたデータをデータベースへ
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
					echo $_POST['speed']."km";
				} ?>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">平均ケイデンス：</label>
				<?php if (isset($_POST['cadence'])) {
					echo $_POST['cadence']."rpm";
				} ?>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">走行距離：</label>
				<?php if (isset($_POST['distance'])) {
					echo $_POST['distance']."km";
				} ?>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">心拍数：</label>
				<?php if (isset($_POST['heartrate'])) {
					echo $_POST['heartrate']."bpm";
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
					echo $_POST['gear']."段";
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
				<input class="form-control" type="date" name="date" placeholder="日付" required value="<?php if(isset($_POST['date'])){echo $_POST['date'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" pattern="^([1-9]\d*|0)(\.\d+)?$" title="数字でご入力ください" name="speed" placeholder="平均速度(km/h)" required value="<?php if(isset($_POST['speed'])){echo $_POST['speed'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" pattern="^([1-9]\d*|0)(\.\d+)?$" title="数字でご入力ください" name="cadence" placeholder="平均ケイデンス(rpm)" required value="<?php if(isset($_POST['cadence'])){echo $_POST['cadence'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" pattern="^([1-9]\d*|0)(\.\d+)?$" title="数字でご入力ください" name="distance" placeholder="走行距離(km)" required value="<?php if(isset($_POST['speed'])){echo $_POST['distance'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" pattern="^[0-9]+$" title="数字でご入力ください" name="heartrate" placeholder="心拍数(bpm)" required value="<?php if(isset($_POST['heartrate'])){echo $_POST['heartrate'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="time" name="time" placeholder="練習時間" required value="<?php if(isset($_POST['time'])){echo $_POST['time'];} ?>">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" pattern="^[0-9]+$" title="数字でご入力ください" name="gear" placeholder="ギア(段)" required value="<?php if(isset($_POST['gear'])){echo $_POST['gear'];} ?>">
			</div>
			<button class="btn btn-default" type="submit" name="confirm" value='cofirm'>確認</button>
		</form>
	<?php endif; ?>
</div>
</body>
</html>
