<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$carts = get_user_carts($db, $user['user_id']);
//カート内のアイテムがバリデーションにより購入出来なければエラーメッセージ、カート画面へリダイレクト

if(purchase_carts($db, $carts) === false){
  set_error('商品が購入できませんでした。');
  redirect_to(CART_URL);
} 

$total_price = sum_carts($carts);
try{
$db->beginTransaction();
//購入履歴テーブルに、user_id,$total_priceを保存する
save_history($db,$user['user_id'],$total_price);
$order_number = $db -> lastInsertId();
//購入明細テーブルに、order_number,item_id,price,amountを保存する
foreach($carts as $cart){
save_details($db,$order_number,$cart['price'],$cart['item_id'],$cart['amount']);
}
$db->commit();
}catch(PDOException $e){
  $db->rollBack();
}
// insert_history_details($db,$user['user_id'],$total_price,$order_number,$cart['price'],$cart['item_id'],$cart['amount']);



include_once '../view/finish_view.php';