<?php
//引数の情報を表示する
function dd($var){
  var_dump($var);
  exit();
}
//自動的に引数のurlへ転送する
function redirect_to($url){
  header('Location: ' . $url);
  exit;
}
//$nameがセットされていれば$_GET[$name]を返す、無ければ空にする
function get_get($name){
  if(isset($_GET[$name]) === true){
    return $_GET[$name];
  };
  return '';
}
//$nameがセットされていれば$_POST[$name]を返す、無ければ空にする
function get_post($name){
  if(isset($_POST[$name]) === true){
    return $_POST[$name];
  };
  return '';
}
//$nameがセットされていれば$_FILE[$name]を返す、無けれ配列にする
function get_file($name){
  if(isset($_FILES[$name]) === true){
    return $_FILES[$name];
  };
  return array();
}
//$nameがセットされていれば$_SESSION[$name]を返す、無けれ空にする
function get_session($name){
  if(isset($_SESSION[$name]) === true){
    return $_SESSION[$name];
  };
  return '';
}
//セッションをセットする
function set_session($name, $value){
  $_SESSION[$name] = $value;
}
//$_SESSION['_errors]をセットする
function set_error($error){
  $_SESSION['__errors'][] = $error;
}
//セッションの＿errorsを$errorsに代入、$errorsが空であれば
function get_errors(){
  $errors = get_session('__errors');
  if($errors === ''){
    return array();
  }
  set_session('__errors',  array());
  return $errors;
}
//エラーが存在し０個でない
function has_error(){
  return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
}
//$_SESSION['_messages']をセットする
function set_message($message){
  $_SESSION['__messages'][] = $message;
}
//$_SSEION['_message']が空なら配列を返す、存在すれば変数に代入した値を返す
function get_messages(){
  $messages = get_session('__messages');
  if($messages === ''){
    return array();
  }
  set_session('__messages',  array());
  return $messages;
}
//$_SESSION['user_id']が空でない
function is_logined(){
  return get_session('user_id') !== '';
}
//アップロードしたファイル名を取得する
function get_upload_filename($file){
  //アップロード画像が無ければ空を返す
  if(is_valid_upload_image($file) === false){
    return '';
  }
  //画像の型を定義する
  $mimetype = exif_imagetype($file['tmp_name']);
  //拡張子を取得
  $ext = PERMITTED_IMAGE_TYPES[$mimetype];
  //20文字のランダムな文字.拡張子を返す
  return get_random_string() . '.' . $ext;
}
//20文字のランダムな文字列を取得
function get_random_string($length = 20){
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}
//アップロードされた画像を指定したディレクトリに保存する
function save_image($image, $filename){
  return move_uploaded_file($image['tmp_name'], IMAGE_DIR . $filename);
}
//指定したディレクトリのファイルが存在していれば、ファイルを削除する
function delete_image($filename){
  if(file_exists(IMAGE_DIR . $filename) === true){
    unlink(IMAGE_DIR . $filename);
    return true;
  }
  return false;
  
}


//文字数のバリデーション
function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX){
  $length = mb_strlen($string);
  return ($minimum_length <= $length) && ($length <= $maximum_length);
}
//正規表現\A[0-9a-zA-Z]+\z/半全角英数字の一回以上の繰り返しでマッチング
function is_alphanumeric($string){
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}
//正規表現\A([1-9][0-9]*|0)\z/でマッチング
function is_positive_integer($string){
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}
//正規表現によるマッチング
function is_valid_format($string, $format){
  return preg_match($format, $string) === 1;
}

// HTTP POST でアップロードされたファイルでなければエラーメッセージ
function is_valid_upload_image($image){
  if(is_uploaded_file($image['tmp_name']) === false){
    set_error('ファイル形式が不正です。');
    return false;
  }
  //イメージの型を定義する
  $mimetype = exif_imagetype($image['tmp_name']);
  //ファイル形式がjpg,pngでなければエラーメッセージ
  if( isset(PERMITTED_IMAGE_TYPES[$mimetype]) === false ){
    set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみ利用可能です。');
    return false;
  }
  return true;
}

function h($name){
  $str=htmlspecialchars($name,ENT_QUOTES,'UTF-8');
  return $str;
}

// トークンの生成
function get_csrf_token(){
  // get_random_string()はユーザー定義関数。
  $token = get_random_string(30);
  // set_session()はユーザー定義関数。
  set_session('csrf_token', $token);
  return $token;
}

// トークンのチェック
function is_valid_csrf_token($token){
  if($token === '') {
    return false;
  }
  // get_session()はユーザー定義関数
  return $token === get_session('csrf_token');
}