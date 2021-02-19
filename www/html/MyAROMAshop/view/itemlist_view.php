<?php
  // クリックジャッキング対策
  header('X-FRAME-OPTIONS: DENY');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'css.css')); ?>">
  <title>商品購入ページ</title>
  
</head>

<?php include_once'../view/templates/header.php';?>
　　<h1>商品一覧</h1>
　　　 <form class="order_by" method="post" action="itemlist.php">
      　<select name="order_by"> 
        　<option value="ASC">金額の低い順</option>
        　<option value="DESC">金額の高い順</option>
          <input type="submit" value="並び替える">
　 　   </select>    
      </form>
      <div class="flex">
          <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'){ ?>
          <?php if(($_POST['order_by']) === "ASC"){ ?>
          <?php foreach($ASC as $value){ ?>
          <div class="menu">
            <span class="img"><img src="<?php print ITEM_IMAGE_DIR.$value['img'];?>" width=250px height=250px></span>
            <span class="name"><?php print $value['name'];?></span>
            <span class="price"><?php print $value['price'];?>円</span>
            <?php if($value['stock'] <= 0){?>
              <span class="soldout">売り切れ</span>
            <?php }else{?>
            <form method="post" action="top_add_cart.php">
              <label for="amount">数量</label>
              <select class="amount_select "name="amount" value="<?php print $value['amount']; ?>">
                <?php $i=1; while($i <= 10){ ?>
                <option value="<?php print $i; ?>"><?php print $i; ?></option>
                <?php $i++; } ?>
              <input class="cart_submit" type="submit" value="カートに入れる" name="in_cart">
              <input type="hidden" name="item_id" value="<?php print $value['item_id'];?>"/>
              <input type="hidden" name="price" value="<?php print $value['price'];?>"/>
              <input type="hidden" name="stock" value="<?php print $value['stock'];?>"/>
              <input type="hidden" name="get_token" value="<?php print $token ; ?>"/>
              <input type="hidden" name="in_cart" value="sale"/>
            </form>
            <?php } ?>
          </div>
          <?php }}else if(($_POST['order_by']) === "DESC"){ ?> 
          <?php foreach($DESC as $value){ ?>
          <div class="menu">
            <span class="img"><img src="<?php print ITEM_IMAGE_DIR.$value['img'];?>" width=250px height=250px></span>
            <span class="name"><?php print $value['name'];?></span>
            <span class="price"><?php print $value['price'];?>円</span>
          
          <?php if($value['stock'] <= 0){?>
              <span class="soldout">売り切れ</span>
            <?php }else{?>
            <form method="post" action="top_add_cart.php">
              <label for="amount">数量</label>
              <select class="amount_select "name="amount" value="<?php print $value['amount']; ?>">
                <?php $i=1; while($i <= 10){ ?>
                <option value="<?php print $i; ?>"><?php print $i; ?></option>
                <?php $i++; } ?>
              <input class="cart_submit" type="submit" value="カートに入れる" name="in_cart">
              <input type="hidden" name="item_id" value="<?php print $value['item_id'];?>"/>
              <input type="hidden" name="price" value="<?php print $value['price'];?>"/>
              <input type="hidden" name="stock" value="<?php print $value['stock'];?>"/>
              <input type="hidden" name="get_token" value="<?php print $token ; ?>"/>
              <input type="hidden" name="in_cart" value="sale"/>
            </form>
            <?php } ?>
          </div>
          <?php }}}else{ foreach($rows as $value){ 
              if($value['status'] === 0){?>
          <div class="menu">
         
          <span class="img"><img src="<?php print ITEM_IMAGE_DIR. $value['img'];?>" width=250px height=250px></span>
          <span class="name"><?php print $value['name'];?></span>
          <span class="price"><?php print $value['price'];?>円</span>
          <?php if($value['stock'] <= 0){?>
              <span class="soldout">売り切れ</span>
            <?php }else{?>
            <form method="post" action="top_add_cart.php">
              <label for="amount">数量</label>
              <select class="amount_select "name="amount" value="<?php print $value['amount']; ?>">
                <?php $i=1; while($i <= 10){ ?>
                <option value="<?php print $i; ?>"><?php print $i; ?></option>
                <?php $i++; } ?>
              <input class="cart_submit" type="submit" value="カートに入れる" name="in_cart">
              <input type="hidden" name="item_id" value="<?php print $value['item_id'];?>"/>
              <input type="hidden" name="price" value="<?php print $value['price'];?>"/>
              <input type="hidden" name="stock" value="<?php print $value['stock'];?>"/>
              <input type="hidden" name="get_token" value="<?php print $token ; ?>"/>
              <input type="hidden" name="in_cart" value="sale"/>
            </form>
            <?php } ?>
          </div>
          <?php }}}?>
       </div>
       <a href="./top.php"><p class="back_top">TOPページに戻る</p></a>
      
    
  </form>
  </body>
  </html>  
          
            
          
          
          
          
         