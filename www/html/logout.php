<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();
$_SESSION = array();
//セッションクッキーのパラメータを取得する
$params = session_get_cookie_params();
//クッキー情報を削除する
setcookie(session_name(), '', time() - 42000,
  $params["path"], 
  $params["domain"],
  $params["secure"], 
  $params["httponly"]
);
//セッションに登録されたデータを全て破棄する
session_destroy();

redirect_to(LOGIN_URL);

