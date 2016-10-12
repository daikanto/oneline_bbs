<?php
	  // ここにDBに登録する処理を記述する
// １．データベースに接続する
$dsn = 'mysql:dbname=oneline_bbs;host=localhost';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);
$dbh->query('SET NAMES utf8');

//post送信が行われたとき
if(!empty($_POST)){
//htmlの変数をphp変数に代入する
	$nickname=$_POST['nickname'];
	$comment=$_POST['comment'];

}

// ２．SQL文を実行する
//DB登録する
$sql = 'INSERT INTO `posts`(`id`, `nickname`, `comment`, `created`) VALUES (null,'"$nickname"','"$comment"',now())';//$変数に変更
$stmt = $dbh->prepare($sql);
$stmt->execute();

// ３．データベースを切断する
$dbh = null;

?>