<?php
  if (!empty($_POST)) {//ポスト送信したときのみに動くようにする
  $nickname = htmlspecialchars($_POST['nickname']);
  $comment = htmlspecialchars($_POST['comment']);
  // １．データベースに接続する

  $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
  $user = 'root';
  $password='';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->query('SET NAMES utf8');
    // ２．SQL文を実行する
    $sql = 'INSERT INTO`posts`(`nickname`,`comment`,`created`) VALUES ("'.$nickname.'","'.$comment.'",now())';
    // SQLを実行
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
  }
  // ２．SQL文を実行する
  // ３．データベースを切断するaaa
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
    <!-- ここにニックネーム、つぶやいた内容、日付を表示する -->
    <div>
    <?php
  if (!empty($_POST)) {
  $nickname = $_POST['nickname'];
  $comment = $_POST['comment'];
}?>
    <h3>つぶやき内容</h3>
    <p>ニックネーム：<?php if (!empty($_POST)){echo $nickname;} ?></p>
    <p>コメント：<?php if (!empty($_POST)){echo $comment;} ?></p>
    </div>
</body>
</html>

<?php
  // １．データベースに接続するaaa
  $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
  $user = 'root';
  $password = '';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->query('SET NAMES utf8');

  // POSTでデータが送信された時のみSQLを実行する
  if (!empty($_POST)) {
    // ２．SQL文を実行する
    $sql = 'SELECT * FROM `posts` ORDER BY id DESC;';
    // SQLを実行
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // データを取得する
    while (1) {
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($rec == false) {
        break;
      }
      echo $rec['id'] . '<br>';
      echo $rec['nickname'] . '<br>';
      echo $rec['comment'] . '<br>';
      echo $rec['created'] . '<br>';
      echo '<hr>';
    }
  }

  // ３．データベースを切断する
  $dbh = null;
?>
</body>
</html>


