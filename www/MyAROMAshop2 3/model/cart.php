<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

//ユーザーのカート情報の参照
function get_user_carts($db, $user_id){
  $sql = "
    SELECT
      ec_item_master.item_id,
      name,
      img,
      status,
      ec_cart.*,
      ec_item_stock.stock
      
    FROM
      ec_cart
    JOIN
      ec_item_master
    ON
      ec_cart.item_id = ec_item_master.item_id
    JOIN
      ec_item_stock
    ON
      ec_item_stock.item_id = ec_item_master.item_id
    WHERE
      ec_cart.user_id =:user_id
  ";
  $array=array(':user_id' => $user_id);
  return fetch_all_query($db, $sql,$array);
}
//ユーザーが選択したアイテム情報を参照
function get_user_cart($db, $user_id, $item_id){
  $sql = "
    SELECT
      ec_item_master.item_id,
      name,
      img,
      status,
      ec_cart.*,
      ec_item_stock.stock
      
    FROM
      ec_cart
    JOIN
      ec_item_master
    ON
      ec_cart.item_id = ec_item_master.item_id
    JOIN
      ec_item_stock
    ON
      ec_item_stock.item_id = ec_item_master.item_id
    WHERE
      ec_cart.user_id =:user_id
    AND
      ec_item_master.item_id = :item_id
  ";
  $array=array(':user_id' => $user_id,':item_id' => $item_id);
  return fetch_query($db, $sql,$array);

}
//カートに追加した商品がカートに無ければ商品を新規追加、既にあれば個数を＋１追加する
function add_cart($db, $user_id,$item_id,$amount,$price) {
  $cart = get_user_cart($db, $user_id, $item_id);
  if($cart === false){
    return insert_cart($db, $user_id, $item_id,$amount,$price);
  }
  return update_add_amount($db,$amount,$cart['id']);
}
//カート内に新規追加
function insert_cart($db, $user_id, $item_id, $amount,$price){
  $sql = "
    INSERT INTO
      ec_cart(
        item_id,
        user_id,
        amount,
        price,
        create_datetime
      )
    VALUES(:item_id, :user_id, :amount, :price ,now())
  ";
  $array=array(':item_id' => $item_id,'user_id' => $user_id,'amount' => $amount,'price' =>$price);
//$sqlを実行する
  return execute_query($db, $sql,$array);
}
//カートに追加された商品の個数を更新する
function update_add_amount($db,$amount,$cart_id){
  $sql = "
    UPDATE
      ec_cart
    SET
      amount = amount+:amount,
      update_datetime=now()
    WHERE
      id = :id
    LIMIT 1
  ";
  $array=array(':amount' => $amount,':id' => $cart_id);
  return execute_query($db, $sql,$array);
}

function update_cart_amount($db,$cart_id,$amount){
  $sql = "
    UPDATE
      ec_cart
    SET
      amount =:amount,
      update_datetime=now()
    WHERE
      id = :id
    LIMIT 1
  ";
  $array=array(':amount' => $amount,':id' => $cart_id);
  return execute_query($db, $sql,$array);
}
//カート内の商品を削除する
function delete_cart($db, $cart_id){
  $sql = "
    DELETE FROM
      ec_cart
    WHERE
      id = :cart_id
    LIMIT 1
  ";
  $array=array(':cart_id' => $cart_id);
  return execute_query($db, $sql,$array);
}
//カート内の商品を購入する際、不具合があればエラーメッセージ、無ければストック数の変更およびユーザーのカート情報を��除する
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
  
  delete_user_carts($db, $cart['user_id']);
  }
}
//ユーザーのカート情報を削除する
function delete_user_carts($db, $user_id){
  $sql = "
    DELETE FROM
      ec_cart
    WHERE
      user_id = :user_id
  ";
  $array=array(':user_id' => $user_id);
  execute_query($db, $sql,$array);
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
//購入履歴をデータベースに保存する
function save_history($db,$user_id,$total_price){
  $sql="
    INSERT INTO
      history(
        user_id,
        total_price
      )
      VALUES(:user_id, :total_price)
      ";
      $array=array(':user_id' => $user_id,':total_price' => $total_price);
        return execute_query($db, $sql,$array);
}
//購入明細をデータベースに保存する
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
    $array=array(':order_number' => $order_number,':price' => $price,':item_id' => $item_id,':amount' => $amount);

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

function get_one_history($db,$order_number){
  $sql = "
  SELECT
    order_number,
    created,
    total_price
  FROM
    history
  
  WHERE
    order_number = :order_number
  
";
$array=array(':order_number' => $order_number);
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