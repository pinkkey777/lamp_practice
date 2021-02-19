<?php
  // クリックジャッキング対策
  header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <title>購入履歴</title>
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'css.css')); ?>">
</head>
<body>
  <?php 
    include TEMPLATE_PATH . 'header.php'; 
  ?>
  <h2>購入履歴</h2>
  <table class="table-bordered " border="1">
        <thead class="thead-light">
          <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
            <th>購入明細へ</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($historys as $history){ ?>
          <tr>
            <td><?php print(h($history['order_number'])); ?></td>
            <td><?php print(h($history['created'])); ?></td>
            <td><?php print(h($history['total_price'])); ?></td>
            <td><form method='post' action='details.php'>
                  <input type='submit' value='購入明細へ'>
                  <input type='hidden' name='order_number' value='<?php print h($history['order_number']);?>'>
                </form>
            </td>
          </tr>
          <?php } ?>

        </tbody>
  </table>

</body>
</html>