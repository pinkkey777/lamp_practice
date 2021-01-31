<?php
    define('MODEL_PATH',  '../model/');
    define('VIEW_PATH', '../view/');
    define('ITEM_VIEW_PATH', '../view/item_list_view/');
    define('TEMPLATE_PATH', '../view/templates/');
    
    define('IMAGE_PATH', 'assets/images/');
    define('STYLESHEET_PATH', './assets/css/');
    define('IMAGE_DIR', 'assets/images/' );
    define('ITEM_IMAGE_DIR', 'assets/img/' );
    
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'codecamp39911');
    define('DB_USER', 'codecamp39911');
    define('DB_PASS', 'codecamp39911');
    define('DB_CHARSET', 'utf8');
   
    define('SIGNUP_URL', 'signup.php');
    define('LOGIN_URL', 'login.php');
    define('LOGOUT_URL', 'logout.php');
    define('HOME_URL', 'top.php');
    define('CART_URL', 'cart.php');
    define('FINISH_URL', 'finish.php');
    define('ADMIN_URL', 'admin.php');
    define('HISTORY_URL', 'history.php');
    
    define('REGEXP_ALPHANUMERIC', '/\A[0-9a-zA-Z]+\z/');
    define('REGEXP_POSITIVE_INTEGER', '/\A([1-9][0-9]*|0)\z/');
    
    
    define('USER_NAME_LENGTH_MIN', 6);
    define('USER_NAME_LENGTH_MAX', 100);
    define('USER_PASSWORD_LENGTH_MIN', 6);
    define('USER_PASSWORD_LENGTH_MAX', 100);
    
    define('USER_TYPE_ADMIN', 1);
    define('USER_TYPE_NORMAL', 2);
    
    define('ITEM_NAME_LENGTH_MIN', 1);
    define('ITEM_NAME_LENGTH_MAX', 100);
    
    define('ITEM_STATUS_OPEN', 1);
    define('ITEM_STATUS_CLOSE', 0);
    
    // define('PERMITTED_ITEM_STATUSES', array(
    //   'open' => 1,
    //   'close' => 0,
    // ));
    
    // define('PERMITTED_IMAGE_TYPES', array(
    //   IMAGETYPE_JPEG => 'jpg',
    //   IMAGETYPE_PNG => 'png',
    // ));
    
    $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset='.DB_CHARSET;
    
    $img_dir    = './img/';    // アップロードした画像ファイルの保存ディレクトリ
    $rows      = array();
    $carts     = array();
    $cart      = array();
    $seles     = array();
    $err_msg   = array();
    $count     = array();
    $SUM       = array();
    $search    = array();
    $orders    = array();
    $new_img_filename = '';   // アップロードした新しい画像ファイル名
    $name='';
    $price='';
    $stock='';
    $item_id='';
    $process_kind = '';
    $result_msg = array();
    $select_drink ='';
    $num_regex = '/^[0-9a-zA-Z]{6,}+$/';
   
   
    
    
  
    ?>