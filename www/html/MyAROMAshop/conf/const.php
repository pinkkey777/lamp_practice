<?php
    define('MODEL_PATH',  '../model/');
    define('VIEW_PATH', '../view/');
    define('ITEM_VIEW_PATH', '../view/item_list_view/');
    define('TEMPLATE_PATH', '../view/templates/');
    
    define('IMAGE_PATH', 'assets/images/');
    define('STYLESHEET_PATH', './assets/css/');
    define('IMAGE_DIR', 'assets/images/' );
    define('ITEM_IMAGE_DIR', './assets/img/' );
    
    define('DB_HOST', 'mysql');
    define('DB_NAME', 'sample');
    define('DB_USER', 'testuser');
    define('DB_PASS', 'password');
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
    
    define('ITEM_STATUS_OPEN', 0);
    define('ITEM_STATUS_CLOSE', 1);


    define('ITEM_SALE_ON', 1);
    define('ITEM_SALE_OFF', 0);
    
    define('PERMITTED_ITEM_STATUSES', array(
      'open' => 0,
      'close' => 1,
    ));
    
    define('PERMITTED_IMAGE_TYPES', array(
      IMAGETYPE_JPEG => 'jpg',
      IMAGETYPE_PNG => 'png',
    ));
   
   
    
    
  
    ?>