<h1>メッセージ一覧</h1>
<a href="new.php">投稿する</a>
<main>
  <?php if (count($posts) > 0) : ?>
    <?php foreach ($posts as $post) : ?>
      <section>
        <h2>
          <?php echo escape($post['username']) ?>
        </h2>
        <div>
          <?php echo escape($post['message']) ?>
        </div>
      </section>
    <?php endforeach; ?>
  <?php else : ?>
    <p>投稿されていません</p>
  <?php endif; ?>
</main>
