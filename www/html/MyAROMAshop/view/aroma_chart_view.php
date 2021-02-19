<?php
  // クリックジャッキング対策
  header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'css.css')); ?>">
  <title>アロマ診断</title>
  
</head>

<?php include_once'../view/templates/header.php';?>
<?php include_once VIEW_PATH . 'templates/messages.php'; ?>
      <h2>アロマ診断</h2>
        <div class="chart">
         <?php if(isset($_POST['chart_start']) === true){ ?>
            <p>どんなシーンで使いますか?</p><br>
            <form method="post"　class="flex"> 
           　　<input class="chart_start" type="submit" name="on" value="仕事や勉強中などオンの時に">
           　　<input class="chart_start" type="submit" name="off" value="休日などゆっくり過ごしたい時に">
         　 </form>
         <?php }else if(isset($_POST['on']) === true) { ?>
            <p>どんな目的で使用したいですか?</p>
            <form method="post"　class="flex"> 
           　　<input class="chart_start" type="submit" name="focus" value="集中したい時に">
           　　<input class="chart_start" type="submit" name="refresh" value="合間の休憩時間に">
         　 </form>
         <?php }else if(isset($_POST['focus']) === true){?>
         <?php include_once ITEM_VIEW_PATH.'type_A_view.php';?> 

         <?php }else if(isset($_POST['refresh']) === true){?>
         <?php include_once ITEM_VIEW_PATH.'type_B_view.php';?> 

         <?php }else if(isset($_POST['off']) === true) { ?>
            <p>どんなタイミングに使いたいですか?</p>
            <form method="post"　class="flex"> 
           　　<input class="chart_start" type="submit" name="noon" value="朝、日中など太陽がある時に">
           　　<input class="chart_start" type="submit" name="night" value="夕方、夜など太陽がない時に">
         　 </form>
         <?php }else if(isset($_POST['noon']) === true){?>
            <p>どんな目的で使用したいですか?</p>
            <form method="post"　class="flex"> 
           　　<input class="chart_start" type="submit" name="morning" value="午前中にスッキリと">
           　　<input class="chart_start" type="submit" name="carefree" value="午後にのんびりと">
         　 </form>
        <?php }else if(isset($_POST['morning']) === true){?>
        <?php include_once ITEM_VIEW_PATH.'type_C_view.php';?>
        <?php }else if(isset($_POST['carefree']) === true){?>
         <?php include_once ITEM_VIEW_PATH.'type_D_view.php';?>
        <?php }else if(isset($_POST['night']) === true) { ?>
            <p>これから何をしますか？</p>
            <form method="post"　class="flex"> 
           　　<input class="chart_start" type="submit" name="private" value="寝るまでのプライベートタイムをゆっくりと過ごす。">
           　　<input class="chart_start" type="submit" name="sleep" value="もう寝るだけ、就寝する。">
         　 </form>
        <?php }else if(isset($_POST['private']) === true){?>
        <?php include_once ITEM_VIEW_PATH.'type_E_view.php';?>
        <?php }else if(isset($_POST['sleep']) === true){?>
         <?php include_once ITEM_VIEW_PATH.'type_F_view.php';?>
        <?php }else{ ?>
            <form method="post"> 
            <input class="chart_start" type="submit" name="chart_start" value="診断スタート">
          </form>
        <?} ?> 

        


      </div>
      <a href="./top.php" class="back_top">TOPページに戻る</a>

  </body>
  </html>