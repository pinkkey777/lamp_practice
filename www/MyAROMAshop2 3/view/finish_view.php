
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'css.css')); ?>">
  <title>商品購入ページ</title>
  
</head>

<?php include_once'../view/templates/header.php';?>
  <body>
    <?php include_once VIEW_PATH . 'templates/messages.php'; ?>
    <div class="finish"><p class="finish_cmt">ご購入ありがとうございました</p></div>
      <h2>購入商品</h2>
      <div class="flex">
      
    <?php foreach($carts as $value){ ?>
            
         <div class="carts">
          <span class="img"><img src="<?php print ITEM_IMAGE_DIR.$value['img'];?>" width=250px height=250px></span>
          <span class="name">商品名:<?php print $value['name'];?></span>
          <span class="name">数量:<?php print $value['amount'];?></span>
          <span class="name">小計:<?php print $value['price']*$value['amount'];?>円</span>
          
          </div>
          <?php }?>
      </div>
       <p class="sum_price">合計:<?php print $total_price;?>円</p>
       <a href="./top.php"><p class="back_top">商品一覧に戻る</p></a>
  </body>
  </html>