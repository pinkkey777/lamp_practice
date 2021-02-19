<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'functions.php';
session_start();


if(is_logined() === false){
  redirect_to(HOME_URL);
}

$db = get_db_connect();      
      
$rows=get_items($db);

$key_word = get_post('key_word');
$searchs = search_item($db,$key_word);

$token=get_csrf_token();


    
     

  


include_once '../view/key_word_view.php';

?>