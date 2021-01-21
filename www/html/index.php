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

//GETで現在のページ数を取得する（未入力の場合は1を挿入）
if (isset($_GET['page'])) {
	$page = (int)$_GET['page'];
} else {
	$page = 1;
}

// 参照スタートのポジションを計算する
//ページが1以上の場合(ページ数*8)-8,それ以外は0にする
if ($page > 1) {
	$start = ($page * 8) - 8;
} else {
	$start = 0;
}


//ページ数に従ってitemsテーブルから8件のデータを取得する
$items=get_item_limit($db,$start);
//itemsテーブルの全ての商品数を取得
$page_num=get_total_items($db);
//総ページ数を求める、端数は繰り上げる
$pagenation = ceil($page_num / 8);

$end = $start+8;
if($page_num < $start+8){
	$end=$page_num;
}
//トークンの生成
$token=get_csrf_token();

include_once VIEW_PATH . 'index_view.php';