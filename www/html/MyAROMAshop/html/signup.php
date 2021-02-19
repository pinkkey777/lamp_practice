<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();
//ログインに成功したらホーム画面へリダイレクト
if(is_logined() === true){
  redirect_to(HOME_URL);
}
//トークンの生成
$token=get_csrf_token();

//signup_view.phpを読み込む
include_once VIEW_PATH . 'signup_view.php';



