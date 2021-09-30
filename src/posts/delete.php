<?php

require_once __DIR__ . '/lib/mysqli.php';

function deletePost($link, $id)
{
  $sql = 'DELETE FROM posts where id=' . $id;
  $result = mysqli_query($link, $sql);

  if (!$result) {
    error_log('Error: fail to delete post');
    error_log("Debbuging Error:" . mysqli_error($link));
    echo 'Error:' . mysqli_error($link);
    echo 'エラー起こってます';
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //削除するメッセージのidを取得
  $id = $_POST['id'];
  echo $id;

  //データベースに接続
  $link = dbConnect();
  //削除処理関数
  deletePost($link, $id);
  mysqli_close($link);
  //一覧ページに遷移
  header("Location: index.php");
}
