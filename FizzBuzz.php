<?php
for ($a = 1; $a <= 100; $a++) { //100まで繰りかえす
  if ((($a % 3) == 0) && (($a % 5) == 0)) {    //変数aに代入された値を3で割った余りが0、かつ、変数aに代入された値を5で割った余りが0の時
    echo 'FizzBuzz';    //FizzBuzzを出力
    echo '<br>';    //改行
  }
  else if (($a % 3) == 0) {    //変数aに代入された値を3で割った余りが0の時
    echo 'Fizz';    //Fizzを出力
    echo '<br>';    //改行
  }
  else if (($a % 5) == 0 ) {    //変数aに代入された値を5で割った余りが0の時
    echo 'Buzz';    //Buzzを出力
    echo '<br>';    //改行
  }
  else {  //それ以外の時
    echo $a;    //数字をそのまま出力
    echo '<br>';    //改行
  }
}
 ?>
