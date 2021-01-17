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
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($one_historys as $history){ ?>
              <tr>
                <td><?php print(h($history['order_number'])); ?></td>
                <td><?php print(h($history['created'])); ?></td>
                <td><?php print(h($history['total_price'])); ?>
              </tr>
              <?php } ?>
            </tbody>
        <thead class="thead-light">
          <tr>
            <th>商品名</th>
            <th>商品価格</th>
            <th>購入数</th>
            <th>小計</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($details as $detail){ ?>
          <tr>
            <td><?php print(h($detail['name'])); ?></td>
            <td><?php print(h($detail['price'])); ?></td>
            <td><?php print(h($detail['amount'])); ?></td>
            <td><?php print(h($detail['price'])*h($detail['amount']))?></td>
          </tr>
          <?php } ?>
        </tbody>
  </table>
</body>
</html>