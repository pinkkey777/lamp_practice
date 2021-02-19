<header>
     <a href="./top.php"><img src="<?php print h(IMAGE_DIR."rogo1.png");?>"></a>
     <form method="post" action="key_word.php" class="key_word">
        <input type="text" name="key_word" placeholder="キーワード検索">
        <input type="submit" value="検索" >
     </form>
     <div class="cart">
       <a class="nav" href=""><?php print 'ようこそ'.$_SESSION['name'].'さん';?></a>
       <a class="nav" href="./logout.php">ログアウト</a>
       <a href="./cart.php" class="nav"><img src="<?php print h(IMAGE_DIR."cart.png");?>" width=30px></img></a>
       
     </div>

    　<div class="header_nav">
        <a class="nav_list" href="top.php#sale">sale商品</a>
        <a class="nav_list" href="./itemlist.php">商品一覧</a>
        <a class="nav_list" href="top.php#purpose">目的から検索</a>
        <a class="nav_list" href="top.php#style">お好みの香りから検索</a>
        <a class="nav_list" href="./recipe.php">アロマレシピ</a>
        <a class="nav_list" href="top.php#ranking">ランキング</a>
        <a class="nav_list" href="aroma_chart.php">アロマ診断</a>
        
      </div>
     </div>
  </header>