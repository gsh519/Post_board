<h1>メッセージの投稿</h1>
<?php if (count($errors) > 0) : ?>
  <ul>
    <?php foreach ($errors as $error) : ?>
      <li><?php echo $error; ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
<form action="create.php" method="POST">
  <div>
    <label for="username">ユーザー名</label>
    <input type="text" id="username" name="username" value="<?php echo $post['username'] ?>">
  </div>
  <div>
    <label for="message">メッセージ</label>
    <textarea name="message" id="message" cols="30" rows="10"><?php echo $post['message'] ?></textarea>
  </div>
  <button type="submit">投稿</button>
</form>
