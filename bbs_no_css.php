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



// ２．SQL文を実行する
//DB登録する
$sql = "INSERT INTO `posts`(`id`, `nickname`, `comment`, `created`) VALUES (null,'".$nickname."','".$comment."',now())";//$変数に変更
$stmt = $dbh->prepare($sql);
$stmt->execute();

}

//sql文の作成
//$sql ='SELECT*FROM`posts`';
$sql ="SELECT `id`, `nickname`, `comment`, `created` FROM `posts` ORDER BY`created` DESC";


//secect文実行

$stmt = $dbh->prepare($sql);
$stmt->execute();


//変数にDBから取得したデータを格納→フェッチ　連想配列に変更するため　また複雑な処理を行うため



//格納する変数の初期化
$posts=array();

//繰り返し文でのデータ取得
while (1) {
	$rec=$stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false){
		break;
	}
//取得したデータを配列に格納しておく
	$posts[]=$rec;

}



// ３．データベースを切断する
$dbh = null;

?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>
</head>
<body>
    <form method="post" action=""><!--自分自身に送信する-->
      <p><input type="text" name="nickname"  placeholder="nickname"></p><!--placeholder枠内の文字出力-->


      <p><textarea type="text" name="comment" placeholder="comment"></textarea></p>
      <p><button type="submit" >つぶやく</button></p>
    </form>
    <!-- ここにニックネーム、つぶやいた内容、日付を表示する -->
    <!--<ul>
    	<li><?php //echo $posts[0] ['nickname'];?> 2016/10/13</li>
    	<li>nick name comment 2016/10/12</li>
    	<li>nick name comment 2016/10/11</li>
    </ul>>
    -->

    <ul>
    <?php
    	foreach ($posts as $post_each) {
    		echo '<li>';
    		echo $post_each['nickname'].' ';
    		echo $post_each['comment'].' ';

    		//日付型に変換
    		$created= strtotime($post_each['created']);

    		//書式を変換
    		$created= date('Y/m/d', $created);

    		echo $created;
    		echo '</li>';
    	}
    ?>
    </ul>
</body>
</html>