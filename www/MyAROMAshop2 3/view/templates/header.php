<header>
     <a href="./top.php"><img src="<?php print h(IMAGE_DIR."rogo1.png");?>"></a>
     <div class="cart">
       <a class="nav" href=""><?php print 'ようこそ'.$_SESSION['name'].'さん';?></a>
       <a class="nav" href="./logout.php">ログアウト</a>
       <a href="./cart.php"><img src="<?php print h(IMAGE_DIR."cart.png");?>" width=30px></img></a>
       
     </div>

    　<div class="header_nav">
        <a class="nav_list" href="#sale">sale商品</a>
        <a class="nav_list" href="./itemlist.php">商品一覧</a>
        <a class="nav_list" href="#purpose">目的から検索</a>
        <a class="nav_list" href="#style">お好みの香りから検索</a>
        <a class="nav_list" href="#aromarecipe">アロマレシピ</a>
        <a class="nav_list" href="#ranking">ランキング</a>
      </div>
     </div>
  </header>