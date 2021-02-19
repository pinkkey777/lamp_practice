<?php
require_once '../conf/const.php';
require_once '../model/functions.php';
session_start();

$_SESSION=array();
if (isset($_COOKIE["PHPSESSID"])) {
        setcookie("PHPSESSID", '', time() - 1800, '/');
    }

session_destroy();

redirect_to(LOGIN_URL);
exit();

//include_once'./view/top_view.php';

?>