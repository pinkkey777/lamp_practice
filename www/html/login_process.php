<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();

if(is_logined() === true){
  redirect_to(HOME_URL);
}

$name = get_post('name');
$password = get_post('password');

$db = get_db_connect();

//トークンを照合し、falseならログイン画面へリダイレクト
$get_token=get_post('get_token');
if(is_valid_csrf_token($get_token) === false){
  redirect_to(LOGIN_URL);
}
//$_SESSION["csrf_token"]を削除する
unset($_SESSION["csrf_token"]);

//ユーザー名とパスワードが一致しなければエラーメッセージ、ログイン画面へリダイレクト
$user = login_as($db, $name, $password);
if( $user === false){
  set_error('ログインに失敗しました。');
  redirect_to(LOGIN_URL);
}
//ログイン成功し、ユーザー権がADMINであればADMIN画面へリダイレクト
set_message('ログインしました。');
if ($user['type'] === USER_TYPE_ADMIN){
  redirect_to(ADMIN_URL);
}
redirect_to(HOME_URL);