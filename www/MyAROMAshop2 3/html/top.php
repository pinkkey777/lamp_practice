<?php
require_once '../conf/const.php';
require_once '../model/functions.php';
require_once '../model/user.php';
require_once '../model/item.php';

session_start();
//session_idがセットされていなければ、ログイン画面へリダイレクト
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
//データベースへ接続
$db = get_db_connect();
//ユーザー情報を参照
$user = get_login_user($db);
$sales=get_items($db);
$orders=get_ranking($db);

//トークンの生成
$token=get_csrf_token();

include_once '../view/top_view.php';