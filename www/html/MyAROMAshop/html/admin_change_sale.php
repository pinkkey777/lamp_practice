<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

//$_SESSION[user_id]がセットされていなければログイン画面にリダイレクト
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
//データベースに接続
$db = get_db_connect();
//ログインユーザー情報の参照
$user = get_login_user($db);
//$userのユーザー権がadminでなければログイン画面へリダイレクト
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

//トークンを照合し、セッションのトークンを削除する
$get_token=get_post('get_token');
if(is_valid_csrf_token($get_token) === false){
  redirect_to(LOGIN_URL);
}
unset($_SESSION["csrf_token"]);

$item_id = get_post('item_id');
$sale_mode = get_post('sale_mode');
//openが選択されたらステータスを公開にする
if($sale_mode === 'on'){
  update_sale_mode($db, $item_id, ITEM_SALE_ON);
  set_message('セール商品を変更しました');
  //closeが選択されたらステータスを非公開にする
}else if($sale_mode === 'off'){
  update_sale_mode($db, $item_id, ITEM_SALE_OFF);
  set_message('セール商品を変更しました');
}else {
  set_error('不正なリクエストです。');
}


redirect_to(ADMIN_URL);