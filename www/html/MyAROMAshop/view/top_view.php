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
<body>
  <?php include_once VIEW_PATH.'templates/header.php';?>
  <?php include_once VIEW_PATH . 'templates/messages.php'; ?>
  <div class="topimg">
    <img src="<?php print h(IMAGE_DIR."topimg.jpeg");?>"width=700px height=400px></img>
    <img src="<?php print h(IMAGE_DIR."top1.jpeg");?>" width=700px height=400px></img>
    <img src="<?php print h(IMAGE_DIR."top.jpeg");?>" width=700px height=400px></img>
    <img src="<?php print h(IMAGE_DIR."top3.jpg");?>" width=700px height=400px></img>
    <img src="<?php print h(IMAGE_DIR."top4.jpeg");?>" width=700px height=400px></img>
  </div>
  <article>
    <section>
      <?php include_once ITEM_VIEW_PATH.'sale_view.php';?>      
    </section>
    <section>
      <h2><a id="purpose">目的から検索</a></h2>
      <div class="poupose">
          <form method="post" class="poupose_form" action="#purpose">
            <div><input class="submit relax" type="submit" name="relax" value="" ><p class="submit_p">リラックス</p></div>
            <div><input class="submit refresh" type="submit" name="refresh" value=""><p class="submit_p">リフレッシュ</p></div>
            <div><input class="submit energy" type="submit" name="energy" value=""><p class="submit_p">元気を出したい時</p></div>
            <div><input class="submit focus" type="submit" name="focus" value=""><p class="submit_p">集中したい時</p></div>
            <div><input class="submit sleep" type="submit" name="sleep" value=""><p class="submit_p">睡眠のために</p></div>
            <div><input class="submit female" type="submit" name="female" value=""><p class="submit_p">女性ケア</p></div>
            <div><input class="submit child" type="submit" name="child" value=""><p class="submit_p">子供と一緒に</p></div>
          </form>
         
        <?php
          if(isset($_POST['relax'])){
          include_once ITEM_VIEW_PATH.'relax_view.php';
          }else if(isset($_POST['refresh'])){
          include_once ITEM_VIEW_PATH.'refresh_view.php';
          }else if(isset($_POST['energy'])){
          include_once ITEM_VIEW_PATH.'energy_view.php';
          }else if(isset($_POST['focus'])){
          include_once ITEM_VIEW_PATH.'focus_view.php';
          }else if(isset($_POST['sleep'])){
          include_once ITEM_VIEW_PATH.'sleep_view.php';
          }else if(isset($_POST['female'])){
          include_once ITEM_VIEW_PATH.'female_view.php';
          }else if(isset($_POST['child'])){
          include_once ITEM_VIEW_PATH.'child_view.php';
          }
        ?> 
      </div>
    </section>
    <section>
      <h2><a id="style">お好みの香りから検索</a></h2>
      <div class="poupose">
          <form method="post" class="poupose_form" action="#style">
            <input class="submit_t floral" type="submit" name="floral" value="フローラル" >
            <input class="submit_t citrus" type="submit" name="citrus" value="柑橘系">
            <input class="submit_t herbs" type="submit" name="herbs" value="ハーブ系">
            <input class="submit_t tree" type="submit" name="tree" value="樹木系">
            <input class="submit_t spice" type="submit" name="spice" value="スパイス系">
            <input class="submit_t resin" type="submit" name="resin" value="樹脂系">
            <input class="submit_t exotic" type="submit" name="exotic" value="エキゾチック系">
          
          </form>
          <?php 
          if(isset($_POST['floral'])){ ?>
            <?php include_once ITEM_VIEW_PATH.'floral_view.php';
            }else if(isset($_POST['citrus'])){
              include_once ITEM_VIEW_PATH.'citrus_view.php';
            }else if(isset($_POST['herbs'])){
              include_once ITEM_VIEW_PATH.'herbs_view.php';
            }else if(isset($_POST['tree'])){
              include_once ITEM_VIEW_PATH.'tree_view.php';
            }else if(isset($_POST['spice'])){
              include_once ITEM_VIEW_PATH.'spice_view.php';
            }else if(isset($_POST['resin'])){
              include_once ITEM_VIEW_PATH.'resin_view.php';
            }else if(isset($_POST['exotic'])){
              include_once ITEM_VIEW_PATH.'exotic_view.php';}?>
      </div>
      
      
    </section>
    
    <section>
     <?php include_once ITEM_VIEW_PATH.'ranking_view.php';?>
    </section>
  </article>
</body>
</html>   
          
       
          
         
          
         
       