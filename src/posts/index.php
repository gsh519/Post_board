<?php

require_once __DIR__ . '/lib/escape.php';
require_once __DIR__ . '/lib/mysqli.php';

function listPosts($link)
{
  $posts = [];
  $sql = 'SELECT username, message FROM posts';
  $result = mysqli_query($link, $sql);

  while ($post = mysqli_fetch_assoc($result)) {
    $posts[] = $post;
  }

  mysqli_free_result($result);

  return $posts;
}

$link = dbConnect();
$posts = listPosts($link);

$title = 'メッセージ一覧';
$content = __DIR__ . 'views/index.php';

include 'views/index.php';
