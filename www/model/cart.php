<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

//ユーザーのカート情報の参照
function get_user_carts($db, $user_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = {$user_id}
  ";
  return fetch_all_query($db, $sql);
}
//ユーザーが選択したアイテム情報を参照
function get_user_cart($db, $user_id, $item_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = {$user_id}
    AND
      items.item_id = {$item_id}
  ";

  return fetch_query($db, $sql);

}
//カートに追加した商品がカートに無ければ商品を新規追加、既にあれば個数を＋１追加する
function add_cart($db, $user_id, $item_id ) {
  $cart = get_user_cart($db, $user_id, $item_id);
  if($cart === false){
    return insert_cart($db, $user_id, $item_id);
  }
  return update_cart_amount($db, $cart['cart_id'], $cart['amount'] + 1);
}
//カート内に新規追加
function insert_cart($db, $user_id, $item_id, $amount = 1){
  $sql = "
    INSERT INTO
      carts(
        item_id,
        user_id,
        amount
      )
    VALUES({$item_id}, {$user_id}, {$amount})
  ";
//$sqlを実行する
  return execute_query($db, $sql);
}
//カートに追加された商品の個数を更新する
function update_cart_amount($db, $cart_id, $amount){
  $sql = "
    UPDATE
      carts
    SET
      amount = {$amount}
    WHERE
      cart_id = {$cart_id}
    LIMIT 1
  ";
  return execute_query($db, $sql);
}
//カート内の商品を削除する
function delete_cart($db, $cart_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      cart_id = {$cart_id}
    LIMIT 1
  ";

  return execute_query($db, $sql);
}
//カート内の商品を購入する際、不具合があればエラーメッセージ、無ければストック数の変更およびユーザーのカート情報を削除する
function purchase_carts($db, $carts){
  if(validate_cart_purchase($carts) === false){
    return false;
  }
  foreach($carts as $cart){
    if(update_item_stock(
        $db, 
        $cart['item_id'], 
        $cart['stock'] - $cart['amount']
      ) === false){
      set_error($cart['name'] . 'の購入に失敗しました。');
    }
  }
  
  delete_user_carts($db, $carts[0]['user_id']);
}
//ユーザーのカート情報を削除する
function delete_user_carts($db, $user_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      user_id = {$user_id}
  ";

  execute_query($db, $sql);
}

//カート内の商品の合計金額を計算
function sum_carts($carts){
  $total_price = 0;
  foreach($carts as $cart){
    $total_price += $cart['price'] * $cart['amount'];
  }
  return $total_price;
}
//カート内の商品を購入する際のエラーメッセージ（カートに商品が入っていない、商品が公開されていない、在庫が足りない）
function validate_cart_purchase($carts){
  if(count($carts) === 0){
    set_error('カートに商品が入っていません。');
    return false;
  }
  foreach($carts as $cart){
    if(is_open($cart) === false){
      set_error($cart['name'] . 'は現在購入できません。');
    }
    if($cart['stock'] - $cart['amount'] < 0){
      set_error($cart['name'] . 'は在庫が足りません。購入可能数:' . $cart['stock']);
    }
  }
  if(has_error() === true){
    return false;
  }
  return true;
}

function save_history($db,$user_id,$total_price){
  $sql="
    INSERT INTO
      history(
        user_id,
        total_price
      )
      VALUES(:user_id, :total_price)
      ";
      $array=array('user_id' => $user_id,'total_price' => $total_price);
        return execute_query($db, $sql,$array);
}

function save_details($db,$order_number,$price,$item_id,$amount){
  $sql="
    INSERT INTO
      details(
        order_number,
        price,
        item_id,
        amount
    )
    VALUES(:order_number,:price,:item_id,:amount)
    ";
    $array=array('order_number' => $order_number,'price' => $price,'item_id' => $item_id,'amount' => $amount);
    
        return execute_query($db, $sql,$array);
}




function get_history($db,$user_id){
  $sql = "
  SELECT
    order_number,
    created,
    total_price
  FROM
    history
  
  WHERE
    user_id = :user_id
  ORDER BY
  order_number DESC;
";
$array=array(':user_id' => $user_id);
return fetch_all_query($db, $sql,$array);
}

function admin_get_history($db){
  $sql = "
  SELECT
    order_number,
    created,
    total_price
  FROM
    history
  
  ORDER BY
  order_number DESC;
";
return fetch_all_query($db, $sql);
}

function get_one_history($db,$user_id,$order_number){
  $sql = "
  SELECT
    order_number,
    created,
    total_price

  FROM
    history
  
  WHERE
    user_id = :user_id AND
    order_number = :order_number
  
";
$array=array(':user_id' => $user_id,':order_number' => $order_number);
return fetch_all_query($db, $sql,$array);
}

function get_details($db,$order_number){
  $sql = "
  SELECT
    items.name,
    details.price,
    details.amount

  FROM
    details
    INNER JOIN items
    ON details.item_id=items.item_id
  WHERE
    details.order_number = :order_number
";
$array=array(':order_number' => $order_number);
return fetch_all_query($db, $sql,$array);
}