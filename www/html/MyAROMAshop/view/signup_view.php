<?php
  // クリックジャッキング対策
  header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'css.css')); ?>">
  <title>ユーザー登録</title>
</head>
<body>
  <header>
  <div><img src="../html/assets/images/rogo1.png"></div>
  </header>
  <div class="content">
      <form class="from" method='post' action="signup_process.php">
          <div><input type="text" name="name" value="" placeholder="ユーザー名"></div>
          <div><input type="password" name="password" placeholder="パスワード"></div>
          <div><input type="password" name="password_confirmation" placeholder="パスワード(確認用)">
          <div><input type="submit" name="sign_up" value="ユーザーを新規作成する"></div>
          <input type="hidden" value="<?php print h($token); ?>" name="get_token">
      </form>
      <?php include_once TEMPLATE_PATH.'messages.php'; ?>
      <?php if(!empty($result_msg)){ ?> <a href="./login.php">ログインページへ移動する</a><?php ;} ?>
      
  </div>
</body>
</html>