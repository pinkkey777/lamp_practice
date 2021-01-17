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
$order_number=get_post('order_number');
$one_historys=get_one_history($db,$user['user_id'],$order_number);
$details=get_details($db,$order_number);

include_once '../view/details_view.php';

?>