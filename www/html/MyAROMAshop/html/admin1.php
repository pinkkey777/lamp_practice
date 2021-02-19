<?php

require_once './conf/const.php';
require_once './model/admin_model.php';
session_start();
      
      
      if(!isset($_SESSION['id']) || $_SESSION['id'] !== 'admin'){
        header('Location:login.php');
        exit;
      }


      
    try{
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        
          if (isset($_POST['new']) === true) {
            $name = get_post_data('name');
            $price = get_post_data('price');
            $stock = get_post_data('stock');
            $status = get_post_data('status');
            $item_id = get_post_data('item_id');
          
          
          
          //バリデーション
          
          
            if($name===""){
              $err_msg[]="ドリンク名を入力してください。";
            }
            if($price===""){
              $err_msg[]="値段を入力してください。";
            }if($stock===""){
              $err_msg[]="在庫数を入力してください。";
            }
            if($status===""){
              $err_msg[]="公開ステータスを入力してください。";
            }
            if((int)$status !== 1 && (int)$status !== 0){
              $err_msg[]='公開ステータスは「公開」、「非公開」のいずれかを選択してください。';
            }
  
           
            
            if(!preg_match('/^[0-9]+$/',$price)) {
              $err_msg[]= '値段は0以上の整数を入力してください';
            }
            if(!preg_match('/^[0-9]+$/',$stock)) {
              $err_msg[] = '在庫数は0以上の整数を入力してください';
            }
          
           
          
            // 画像アップロード、保存
        
            // HTTP POST でファイルがアップロードされたかどうかチェック
            if (is_uploaded_file($_FILES['new_img']['tmp_name']) === TRUE) {
              // 画像の拡張子を取得
              $extension = pathinfo($_FILES['new_img']['name'], PATHINFO_EXTENSION);
              // 指定の拡張子であるかどうかチェック
              if ($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg' || $extension === 'PNG' || $extension === 'JPEG' || $extension === 'JPG') {
                // 保存する新しいファイル名の生成（ユニークな値を設定する）
                $new_img_filename = sha1(uniqid(mt_rand(), true)). '.' . $extension;
                // 同名ファイルが存在するかどうかチェック
                if (is_file($img_dir . $new_img_filename) !== TRUE) {
                  // アップロードされたファイルを指定ディレクトリに移動して保存
                  if (move_uploaded_file($_FILES['new_img']['tmp_name'], $img_dir . $new_img_filename) !== TRUE) {
                      $err_msg[] = 'ファイルアップロードに失敗しました';
                  }
                } else {
                  $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
                }
              } else {
                $err_msg[] = 'ファイル形式が異なります。画像ファイルはJPEGまたはPNGのみ利用可能です。';
              }
            } else {
              $err_msg[] = 'ファイルを選択してください';
            }
           
          
          //drink_master,drink_stockへの登録------------
         
            if(empty($err_msg)){
                try{
                  $dbh->beginTransaction();
                  $sql = 'INSERT INTO ec_item_master(name,price,img,status,type,purpose,sale,create_datetime) VALUES(?,?,?,?,?,?,?,now())';
                  INSERT_INTO_ec_item_master($dbh,$sql,$name,$price,$new_img_filename,$status);
                  $drink_id=$dbh->lastInsertId();
                  $sql='INSERT INTO ec_item_stock(stock,create_datetime,update_datetime) VALUES(?,now(),now())';
                  bv_stock_execute($dbh,$sql,$stock);
                  $dbh->commit();
                }catch (PDOException $e) {
                  // 接続失敗した場合
                  $dbh->rollback();
                  throw $e;
                }
              }
           }
          //在庫数の変更
       
            if(isset($_POST['change']) === TRUE) {
              if(isset($_POST['item_id'])){
                $item_id=$_POST['item_id'];
              }
              if(isset($_POST['change_num'])){
              $change_num=$_POST['change_num'];
              }
              if(!preg_match('/^[0-9]+$/',$change_num)) {
              $err_msg[] = '在庫数の変更は0以上の整数を入力してください';
              }
              
              if(empty($err_msg)){
                  $sql='UPDATE ec_item_stock set stock=?,update_datetime=now() where item_id=?';
                  UPDATE_ec_item_stock($dbh,$sql,$item_id,$change_num);
             }
            }
        
        //公開、非公開の変更
            if(isset($_POST['status_change']) === TRUE){
              
                if((int)($_POST['status']) === 1){
                
                $sql='UPDATE ec_item_master set status= 0, update_datetime=now() where item_id= ?';
                bv_item_id_execute($dbh,$sql);
                }else if((int)($_POST['status']) === 0){
              
                $sql='UPDATE ec_item_master set status= 1, update_datetime=now() where item_id= ?';
                bv_item_id_execute($dbh,$sql);
            
            }
        //商品データを削除
        }
            if(isset($_POST['delete']) === TRUE){
              
                $sql='DELETE FROM ec_item_master  WHERE item_id=?';
                bv_item_id_execute($dbh,$sql);
              
                $sql='DELETE FROM ec_cart  WHERE item_id=?';
                bv_item_id_execute($dbh,$sql);
            }
      
           //セールの変更
           
           if(isset($_POST['sale_change']) === TRUE){
                if((int)($_POST['sale_mode']) === 0){
                
                $sql='UPDATE ec_item_master set sale= 1, update_datetime=now() where item_id= ?';
                bv_item_id_execute($dbh,$sql);
                }else if((int)($_POST['sale_mode']) === 1){
                
                $sql='UPDATE ec_item_master set sale= 0, update_datetime=now() where item_id= ?';
                bv_item_id_execute($dbh,$sql);
             print $_POST['sale_mode'].$_POST['item_id'];
            }
          
        }
        if(isset($_POST['process_kind'])){
            $process_kind = $_POST['process_kind'];
          }
      
        if(empty($err_msg)){
              if($process_kind === 'insert_item'){
                $result_msg[]= "商品を追加しました";
              } else if($process_kind  === 'update_stock'){
                $result_msg[]= "在庫数を更新しました";
              } else if($process_kind === 'change_status'){
                $result_msg[]= "ステータスを更新しました";
              } else if($process_kind === 'delete'){
                $result_msg[]= "商品を削除しました";
              }
          }
      }
       
      
      
     
      
      
      //登録された内容を参照

      $sql = 'SELECT ec_item_master.item_id,name,img,price,status,type,purpose,sale, ec_item_stock.stock FROM ec_item_master INNER JOIN ec_item_stock on ec_item_master.item_id=ec_item_stock.item_id ';
      $rows= get_as_array($dbh, $sql); 
      // var_dump($rows);
    }catch (PDOException $e) {
      $err_msg['db_connect'] = 'DBエラー：'.$e->getMessage();
    }






include_once'./view/admin_view.php';

?>