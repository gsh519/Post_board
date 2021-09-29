<?php

require_once __DIR__ . '/lib/mysqli.php';

function createPost($link, $post)
{
  $sql = <<<EOT
INSERT INTO posts(
  username,
  message
) VALUES (
  "{$post['username']}",
  "{$post['message']}"
)
EOT;
  $result = mysqli_query($link, $sql);
  if (!$result) {
    error_log('Error: fail to create post');
    error_log('Debbuging Error:' . mysqli_error($link));
  }
}

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

//HTTPメソッドがPOSTだったら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $post = [
    'username' => $_POST['username'],
    'message' => $_POST['message']
  ];

  //バリデーションする
  $errors = validate($post);
  //バリデーションエラーがなければ
  if (!count($errors)) {
    $link = dbConnect();
    createPost($link, $post);
    mysqli_close($link);
    header("Location: index.php");
  }
  //もしエラーがあれば
}

include 'views/new.php';
