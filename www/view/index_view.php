<?php
  // クリックジャッキング対策
  header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'index.css')); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  

  <div class="container">
    <h1>商品一覧</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
        <p><?php print h($page_num);?>件中<?php print h($start+1).'-'.h($end);?>件目の商品</p>
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <?php if($page >1){?>
            <li class="page-item"><a class="page-link" href="?page=<?php print h($page)-1;?>">前へ</a></li>
            <?php }?>
            <?php for ($x=1; $x <= $pagenation ; $x++) { ?>
            <?php if($x == $page){ ?>
            <li class="page-item active"><span class="page-link"><?php print h($page); ?></span></li>
            <?php }else{ ?>
            <li class="page-item"><a class="page-link" href="?page=<?php print h($x); ?>"><?php print h($x); ?></a></li>
            <?php }}?>
    　　     <?php if($page < $pagenation){ ?>
            <li class="page-item"><a class="page-link" href="?page=<?php print h($page+1); ?>">次へ</a></li>
            <?php }?>
            
          </ul>
        </nav>
  
    <div class="card-deck">
      <div class="row">
      <?php foreach($items as $item){ ?>
        <div class="col-6 item">
          <div class="card h-100 text-center">
            <div class="card-header">
              <?php print(h($item['name'])); ?>
            </div>
            <figure class="card-body">
              <img class="card-img" src="<?php print(h(IMAGE_PATH . $item['image'])); ?>">
              <figcaption>
                <?php print(h(number_format($item['price']))); ?>円
                <?php if($item['stock'] > 0){ ?>
                  <form action="index_add_cart.php" method="post">
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                    <input type="hidden" name="item_id" value="<?php print(h($item['item_id'])); ?>">
                    <input type="hidden" value="<?php print h($token); ?>" name="get_token">
                  </form>
                <?php } else { ?>
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
  
</body>
</html>