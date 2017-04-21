<?php

  // １．データベースに接続する

  $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
  $user = 'root';
  $password='';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->query('SET NAMES utf8');
    // ２．SQL文を実行する
  if (!empty($_POST)) {//ポスト送信したときのみに動くようにする
   $nickname = htmlspecialchars($_POST['nickname']);
   $comment = htmlspecialchars($_POST['comment']);
    $sql = 'INSERT INTO`posts`(`nickname`,`comment`,`created`) VALUES ("'.$nickname.'","'.$comment.'",now())';
    // SQLを実行
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $sql = 'SELECT * FROM `posts` ORDER BY id DESC;';
    // SQLを実行
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
 
    $post_datas=array();

    while (1) {
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
        break;
      }
     $post_datas[]=$rec; 
     }
     var_dump($sql);
    }
  $dbh = null;
  ?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>
</head>
<body>
    <form method="post" action="">
      <p><input type="text" name="nickname" placeholder="nickname"></p>
      <p><textarea type="text" name="comment" placeholder="comment"></textarea></p>
      <p><button type="submit" >つぶやく</button></p>
    </form>

<?php
  if (!empty($_POST)) {
  // POSTでデータが送信された時のみSQLを実行する
  foreach ($post_datas as $post_each) {
      echo $post_each['nickname'] . '<br>';
      echo $post_each['comment'] . '<br>';
      echo $post_each['created'] . '<br>';
      echo '<hr>';
    }
   }
?>
    </body>
</html>

