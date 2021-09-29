<?php

function validate($post)
{
  $errors = [];

  //ユーザー名のバリデーション
  if (!strlen($post['username'])) {
    $errors['username'] = 'ユーザー名を入力してください';
  } elseif (strlen($post['username'] > 255)) {
    $errors['username'] = 'ユーザー名は255文字以内で入力してください';
  }

  //メッセージのバリデーション
  if (!strlen($post['message'])) {
    $errors['message'] = 'メッセージを入力してください';
  } elseif (strlen($post['message'] > 1000)) {
    $errors['message'] = 'ユーザー名は1000文字以内で入力してください';
  }

  return $errors;
}

function createPosts($link)
{

  $post = [];

  echo '投稿を入力してください' . PHP_EOL;
  echo 'ユーザー名を入力してください：';
  $post['username'] = trim(fgets(STDIN));
  echo 'メッセージを入力してください：';
  $post['message'] = trim(fgets(STDIN));
  echo '投稿が完了しました' . PHP_EOL;

  $validated = validate($post);
  if (count($validated) > 0) {
    foreach ($validated as $error) {
      echo $error . PHP_EOL;
    }
    return;
  }

  $sql = <<<EOT
INSERT INTO posts (
  username,
  message
) VALUES (
  "{$post['username']}",
  "{$post['message']}"
)
EOT;

  $result = mysqli_query($link, $sql);
  if ($result) {
    echo 'データを追加しました' . PHP_EOL;
  } else {
    echo 'Error:データの追加に失敗しました' . PHP_EOL;
    echo 'Debbugin Error:' . mysqli_error($link) . PHP_EOL;
  }
}

function listPosts($link)
{
  echo '登録されている投稿を表示します';

  $sql = 'SELECT username, message FROM posts';
  $result = mysqli_query($link, $sql);

  while ($post = mysqli_fetch_assoc($result)) {
    echo 'ユーザー名：' . $post['username'] . PHP_EOL;
    echo 'メッセージ：' . $post['message'] . PHP_EOL;
    echo '-------------------------------' . PHP_EOL;
  }

  mysqli_free_result($result);
}

function dbConnect()
{
  $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

  if (!$link) {
    echo 'Error:データベースに接続できませんでした' . PHP_EOL;
    echo mysqli_connect_error() . PHP_EOL;
    exit;
  }

  echo 'データベースに接続できました' . PHP_EOL;
  return $link;
}

$posts = [];

$link = dbConnect();


while (true) {
  echo '1. メッセージを投稿' . PHP_EOL;
  echo '2. メッセージ一覧を表示' . PHP_EOL;
  echo '9. アプリケーションを終了' . PHP_EOL;
  echo '番号を入力してください(1,2,9)：' . PHP_EOL;
  $num = trim(fgets(STDIN));

  if ($num === '1') {
    //メッセージ投稿
    $posts[] = createPosts($link);
  } elseif ($num === '2') {
    //メッセージ一覧
    listPosts($link);
  } elseif ($num === '9') {
    //アプリケーション終了
    mysqli_close($link);
    break;
  }
}
