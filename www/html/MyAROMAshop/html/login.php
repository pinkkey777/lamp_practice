<?php
require_once '../conf/const.php';
require_once '../model/functions.php';

session_start();
//ログイン成功したら、ホーム画面へリダイレクtp

if(is_logined() === true){
  redirect_to(HOME_URL);
}

//トークンの生成
$token=get_csrf_token();

include_once '../view/login_view.php';

?>