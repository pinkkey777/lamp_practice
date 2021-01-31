

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
            
          </div>
          <?php }}else if(($_POST['order_by']) === "DESC"){ ?> 
          <?php foreach($DESC as $value){ ?>
          <div class="menu">
            <span class="img"><img src="<?php print ITEM_IMAGE_DIR.$value['img'];?>" width=250px height=250px></span>
            <span class="name"><?php print $value['name'];?></span>
            <span class="price"><?php print $value['price'];?>円</span>
          </div>
          <?php }}}else{ foreach($rows as $value){ 
              if($value['status'] === 0){?>
          <div class="menu">
         
          <span class="img"><img src="<?php print ITEM_IMAGE_DIR. $value['img'];?>" width=250px height=250px></span>
          <span class="name"><?php print $value['name'];?></span>
          <span class="price"><?php print $value['price'];?>円</span>
          </div>
          <?php }}}?>
       </div>
       <a href="./top.php"><p class="back_top">TOPページに戻る</p></a>
      
    
  </form>
  </body>
  </html>  
          
            
          
          
          
          
         