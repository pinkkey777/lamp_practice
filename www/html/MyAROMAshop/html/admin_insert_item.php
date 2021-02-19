<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();

$user = get_login_user($db);

if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}
//トークンを照合し、falseならログイン画面へリダイレクト
$get_token=get_post('get_token');
if(is_valid_csrf_token($get_token) === false){
  redirect_to(LOGIN_URL);
}
//$_SESSION["csrf_token"]を削除する
unset($_SESSION["csrf_token"]);

$name = get_post('name');
$price = get_post('price');
$status = get_post('status');
$stock = get_post('stock');
$type = get_post('type');
$purpose = get_post('purpose');

$image = get_file('new_img');
//アイテム情報とアップロード画像を新規作成する
if(regist_item($db, $name, $price, $status, $image, $type, $purpose,$stock)){
  set_message('商品を登録しました。');
}else {
  set_error('商品の登録に失敗しました。');
}



redirect_to(ADMIN_URL);