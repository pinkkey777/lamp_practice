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
$password_confirmation = get_post('password_confirmation');

$db = get_db_connect();

//トークンを照合し、falseならログイン画面へリダイレクト
$get_token=get_post('get_token');
if(is_valid_csrf_token($get_token) === false){
  redirect_to(LOGIN_URL);
}
//$_SESSION["csrf_token"]を削除する
unset($_SESSION["csrf_token"]);

//ユーザー情報を新規登録する、失敗した場合はエラーメッセージ、サインアップ画面へリダイレクtp
try{
  $result = regist_user($db, $name, $password, $password_confirmation);
  if( $result=== false){
    set_error('ユーザー登録に失敗しました。');
    redirect_to(SIGNUP_URL);
  }
}catch(PDOException $e){
  set_error('ユーザー登録に失敗しました。');
  redirect_to(SIGNUP_URL);
}
//サインアップに成功したら、ログインしホーム画面へリダイレクト
set_message('ユーザー登録が完了しました。');
login_as($db, $name, $password);
redirect_to(HOME_URL);