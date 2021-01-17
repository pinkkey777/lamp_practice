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
//カートの合計金額を計算
$total_price = sum_carts($carts);

$historys=get_history($db,$user['user_id']);
if(is_admin($user) === true){
    $historys=admin_get_history($db);
}
//トークンの生成
$token=get_csrf_token();

include_once VIEW_PATH . 'history_view.php';