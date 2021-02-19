<?php
require_once '../conf/const.php';
require_once '../model/functions.php';
session_start();
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

include_once '../view/recipe_view.php';