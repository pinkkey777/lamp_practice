<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'functions.php';
session_start();

$ASC = array();
$DESC = array();

if(is_logined() === false){
  redirect_to(HOME_URL);
}

$db = get_db_connect();      
      
$rows=get_items($db);

$order_by_asc=get_post('ASC');            
$order_by_desc=get_post('DESC');           

$ASC=get_item_asc($db);
$DESC=get_item_desc($db);

$token=get_csrf_token();
    
     

  


include_once'../view/itemlist_view.php';

?>