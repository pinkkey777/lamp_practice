<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
   <link rel="stylesheet" href="../html/assets/css/css.css">
  <title>ログインページ</title>
 
</head>
<body>
  <header>
     <div><img src="../html/assets/images/rogo1.png"></div>
  </header>
  <div class="content">
      <?php include 'templates/messages.php'; ?>
      <form class="from" method="post" action="login_process.php">
        <?php if(!empty($err_msg)){?>
        <?php foreach($err_msg as $value){print $value ;}}?>
          <div><input type="text" name="user_name" placeholder="ユーザー名"></div>
          <div><input type="password" name="password" placeholder="パスワード"></div>
          <div><input type="submit" name="login" value="ログイン"></div>
          <input type="hidden" value="<?php print h($token); ?>" name="get_token">
          <!--<div><input type="hidden" name="login_id" value="<?php print $login['user_id'];?>"></div>-->
          <div class="a"><a href="register.php">ユーザーの新規作成</a></div>
        <!--<?php if(!empty($result_msg)){ ?>-->
        <!--<?php foreach($result_msg as $value) {print $value ;}}?>-->
      </form>
  </div>
</body>
</html>