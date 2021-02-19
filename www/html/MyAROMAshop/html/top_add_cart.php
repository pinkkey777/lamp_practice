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

//トークンを照合し、falseならログイン画面へリダイレクト
$get_token=get_post('get_token');
if(is_valid_csrf_token($get_token) === false){
  redirect_to(LOGIN_URL);
}
//$_SESSION["csrf_token"]を削除する
unset($_SESSION["csrf_token"]);


$item_id = get_post('item_id');
$amount = get_post('amount');
$price = get_post('price');
// insert_cart($db, $user['user_id'], $item_id, $amount,$price);
if(add_cart($db, $user['user_id'], $item_id,$amount,$price)){
  set_message('カートに追加しました');
} else{
  set_error('カートの更新に失敗しました。');
}

//カートに商品を新規追加、または個数更新
redirect_to('top.php');