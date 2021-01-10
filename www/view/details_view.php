<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'admin.css')); ?>">
</head>
<body>
  <?php 
    include VIEW_PATH . 'templates/header_logined.php'; 
  ?>
  <table class="table table-bordered text-center">
        <thead class="thead-light">
          <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($historys as $history){ ?>
          <tr>
            <td><?php print(h($history[''])); ?></td>
            <td><?php print(h($history[''])); ?></td>
            <td><?php print(h($history[''])); ?></td>
          </tr>
          <?php } ?>
        </tbody>
  </table>
  <table class="table table-bordered text-center">
        <thead class="thead-light">
          <tr>
            <th>商品名</th>
            <th>商品価格</th>
            <th>購入数</th>
            <th>小計</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($items as $item){ ?>
          <tr>
            <td><?php print(h($item[''])); ?></td>
            <td><?php print(h($item[''])); ?></td>
            <td><?php print(h($item[''])); ?></td>
          </tr>
          <?php } ?>
        </tbody>
  </table>
</body>
</html>