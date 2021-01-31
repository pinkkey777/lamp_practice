
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'css.css')); ?>">
  <title>商品購入ページ</title>
  
</head>

<?php include_once'../view/templates/header.php';?>
  
      <h2>ショッピングカート</h2>
      <div class="flex">
           <?php if(!empty($err_msg)){ ?>
           <?php foreach($err_msg as $value){ ?>
           <?php print $value ;}} ?>
           <?php foreach($carts as $value){?>
          <div class="carts">
          <span class="img"><img src="<?php print ITEM_IMAGE_DIR.$value['img'];?>" width=250px height=250px></span>
          <span class="name">商品名:<?php print h($value['name']);?></span>
          <?php if($value['status'] === 1){ ?>
            <span>こちらの商品は非公開になりましたので購入出来ません</span>
            <form method="post">
               <span><input type="submit" name="delete" value="削除"></span>
                <input type="hidden" name="id" value="<?php print $value['id'];?> ">
            </form>
            </div>
            <?php }else{?>
          <span class="name">小計:<?php print $value['price']*$value['amount'];?>円</span>
              <div class="change_delete">
                  <form method="post" action="cart_change_amount.php">
                      <label for="amount">数量</label>
                      <select class="amount_select "name="amount_change" value="0">
                        <option selected><?php print $value['amount'];?></option>
                        <?php $i=1; while($i <= 10){ ?>
                        <option value="<?php print $i; ?>"><?php print $i; ?></option>
                        <?php $i++; } ?>
                      <input type="hidden" value='<?php print $value['item_id'] ;?>' name="item_id" >
                      <input type="submit" value="変更" name="change">
                      <input type="hidden" name ="process_kind" value="update_stock">
                      <input type="hidden" name ="get_token" value="<?php print h($token);?>">
                      <input type="hidden" name="id" value="<?php print $value['id'];?> ">
                  </form>
                  <form method="post" action="cart_delete_cart.php">
                      <input  type="submit" name="delete" value="削除">
                      <input type="hidden" name="process_kind" value="delete">
                      <input type="hidden" name="stock" value="<?php print $value['stock'];?> ">
                      <input type="hidden" name ="get_token" value="<?php print h($token);?>">
                      <input type="hidden" name="id" value="<?php print $value['id'];?> ">
                  </form>
              </div>
          </div>  
         <?php }} ?>
      </div>
      <div>
           
          <p class="sum_price">合計:<?php print $total_price;?>円</p>
          
      </div>
    <?php foreach($carts as $value){ ?> 
      <form method="post" action="./finish.php">
          <input type="hidden" name="item_id" value="<?php print $value['item_id'];?> ">
          <input type="hidden" name="amount" value="<?php print $value['amount'];?> ">
          <input type="hidden" name="stock" value="<?php print $value['stock'];?> ">
          <input type="hidden" name="status" value="<?php print $value['status'];?> ">
      <?php } ?>
          <input class="buy" type="submit" value="購入する" name="purchase">
      </form>
    
      
      <a href="./top.php"><p class="back_top">TOPページに戻る</p></a>
  </body>
  </html>