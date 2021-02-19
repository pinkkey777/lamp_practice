<?php
  // クリックジャッキング対策
  header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>商品管理ページ</title>
  <style type= "text/css">
    table {
      width: 1100px;
      border-collapse: collapse;
    }
    table, tr, th, td {
      border: solid 1px;
      padding: 10px;
      text-align: center;
    }
    .private {
      background-color:gray;
    }
  </style>
</head>
<body>
  <header>
    <a href="./logout.php">ログアウト</a>
  </header>
  <?php include_once VIEW_PATH . 'templates/messages.php'; ?>
    <h1>MyAROMAshop 管理ページ</h1>
    <a href="./user.php">ユーザー管理ページ</a>
    <h2>新規商品追加</h2>
    <form method='post' enctype="multipart/form-data" action="admin_insert_item.php">
        <div>名前：<input type="text" name="name"/></div>
        <div>値段：<input type="text" name="price"></div>
        <div>個数：<input type="text" pattern="^[0-9]+$"name="stock"></div>
        <select name="type" >
            <option name="floral" value="floral">フローラル</option>
            <option name="citrus" value="citrus">柑橘系</option>
            <option name="herbs" value="herbs">ハーブ系</option>
            <option name="tree" value="tree">樹木系</option>
            <option name="spice" value="spice">スパイス系</option>
            <option name="resin" value="resin">樹脂系</option>
            <option name="exotic" value="exotic">エキゾチック系</option>
          </select>
          <select name="purpose" >
            <option name="relax" value="relax">リラックス</option>
            <option name="refresh" value="refresh">リフレッシュ</option>
            <option name="energy" value="energy">元気を出したい時</option>
            <option name="focus" value="focus">集中力を高めたい時</option>
            <option name="sleep" value="sleep">睡眠のために</option>
            <option name="female" value="female">女性ケア</option>
            <option name="child" value="child">お子様と一緒に</option>
          </select>
        <div><input type="file" name="new_img"></div>
        <div><select name="status"></div>
            <option name="公開" value="open">公開</option>
            <option name="非公開" value="close">非公開</option>
            <option name="" value="2"></option>
            </select>
        <input type='hidden' name ="process_kind" value = "insert_item">
        <input type="hidden" name ="get_token" value="<?php print h($token);?>">
        <div><input type="submit" name="new" value="◼◻◼◻◾️️️️商品を追加◼◻◼◻◼"></div>
      
    </form>
    <h2>商品情報一覧・変更</h2>
        <p>商品一覧</p>
        <table>
        <tr>
          <th>商品画像</th><th style="width:300px;">商品名</th><th>価格</th><th>在庫数</th><th>ステータス</th><th>操作</th><th>香り</th><th>目的</th><th>セール</th>
        </tr>
    <?php foreach($items as $value){ ?>
    <tr class=<?php if((int)($value['status']) === 1){?>"private"<?php ; } ?>>
      <td><img src="<?php print h(ITEM_IMAGE_DIR.$value['img']);?>" width=250px height=250px></td>
        <td class="name"><?php print  h($value['name']);?></td>
        <td><?php print $value['price'];?></td>
        <td>
          <form method='post' action="admin_change_stock.php">
            <input type="text" value='<?php print $value['stock'] ;?>' name="stock" style="width:100px;">個
            <input type="hidden" value='<?php print $value['item_id'] ;?>' name="item_id" >
            <input type="hidden" name ="get_token" value="<?php print h($token);?>">
            <input type="submit" value="変更" name="change">
            <input type="hidden" name ="process_kind" value="update_stock">
          </form>
        </td>
        <td>
          <form method='post' action="admin_change_status.php">
          <?php if(is_open($value) === true){ ?>
            <input type="submit" value="公開 → 非公開" class="btn btn-secondary">
            <input type="hidden" name="changes_to" value="close">
          <?php } else { ?>
            <input type="submit" value="非公開 → 公開" class="btn btn-secondary">
            <input type="hidden" name="changes_to" value="open">
          <?php } ?>
          <input type="hidden" name="item_id" value="<?php print(h($value['item_id'])); ?>">
          <input type="hidden" value="<?php print h($token); ?>" name="get_token">
          </form>
        <td>
          <form method='post' action='admin_delete_item.php'>
            <input type="submit" name="delete" value="削除">
            <input type="hidden" name ="get_token" value="<?php print h($token);?>">
            <input type="hidden" name="process_kind" value = "delete">
            <input type="hidden" name="item_id" value="<?php print $value['item_id'];?> ">
          </form>
        </td>
        <td>
          <?php print $value['type'];?>
        </td>
        <td>
          <?php print $value['purpose'];?>
        </td>
        <td>
          <form method='post' action="admin_change_sale.php">
          <?php if($value['sale'] === 1){ ?>
          <input type="submit" value="ON→OFF">
          <input type="hidden" name="sale_mode" value="off">
          <?php }else { ?>
          <input type="submit" value="OFF→ON">
          <input type="hidden" name="sale_mode" value="on">
          <?php } ?>
          <input type="hidden" name="item_id" value="<?php print $value['item_id'];?> ">
          <input type="hidden" name ="get_token" value="<?php print h($token);?>">
          </form>
        </td>
        
        </td>
      <tr>
    <?php } ?>

      </table>
</body>
</html>