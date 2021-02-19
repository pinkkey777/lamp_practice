<?php
require_once './conf/const.php';
require_once './model/register_model.php';

 $user_name=get_post_data('user_name');
 $password=get_post_data('password');
 
 
 session_start();
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if($user_name === ''){
    $err_msg[] =  'ユーザー名を入力してください。';
  }
  if($password === ''){
    $err_msg[] =  'パスワードを入力してください。';
  }
  if(!preg_match('/^[0-9a-zA-Z]{6,}+$/',$user_name)) {
                $err_msg[]= 'ユーザー名は半角英数字６文字以上で入力してください';
              }
  if(!preg_match('/^[0-9a-zA-Z]{6,}+$/',$password)) {
                $err_msg[]= 'パスワードは半角英数字６文字以上で入力してください';
              }
             
  //新規登録情報を保存
  if(isset($_POST['sign_up']) === TRUE){
    //重複登録を防止
    try{
        $sql='SELECT COUNT(*) AS cnt FROM ec_user WHERE user_name=?';
        $stmt= $dbh->prepare($sql);
        $stmt->bindValue(1,$user_name, PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->fetch();
        // var_dump($count);
      }catch (PDOException $e) {
        throw $e;
      }
      
      
    if($count['cnt'] > 0){
      $err_msg[]='ユーザー名が既に登録されています。';
    }
    
    
    
    //
    if(empty($err_msg)){
      try{
        $sql='INSERT INTO ec_user(user_name,password,create_datetime) VALUES(?,?,now())';
        $stmt= $dbh->prepare($sql);
        $stmt->bindValue(1,$_POST['user_name'], PDO::PARAM_INT);
        $stmt->bindValue(2,($_POST['password']), PDO::PARAM_INT);
        $stmt->execute();
      }catch (PDOException $e) {
        throw $e;
      }
      $result_msg[]='新規登録が完了しました。';
      
      
      
    }
  }

}


include_once'./view/register_view.php';

?>