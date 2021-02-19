<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// DB利用
//指定したアイテムの情報をfetchで参照する
function get_item($db, $item_id){
  $sql = "
    SELECT
      item_id, 
      name,
      price,
      img,
      status,
      type,
      purpose,
      sale,
      stock
    FROM
      ec_item_master
    
    WHERE
      item_id = :item_id
  ";
  $array=array(':item_id' => $item_id);
  return fetch_query($db, $sql,$array);
}
//アイテム情報を全て参照する
function get_items($db){
  $sql = "SELECT
            item_id,
            name,
            img,
            price,
            status,
            type,
            aroma_type,
            purpose,
            sale,
            stock
          FROM
            ec_item_master
        ";
          
          


  return fetch_all_query($db, $sql);
}
//全てのアイテム情報を参照する
function get_all_items($db){
  return get_items($db);
}
//公開のアイテム情報を参照する
function get_open_items($db){
  return get_items($db, true);
}
//アイテム情報のバリデーションでtrueであればアイテム情報と画像を新規作成する
function regist_item($db, $name, $price, $status, $image, $type, $purpose,$stock){
  $filename = get_upload_filename($image);
  if(validate_item($name, $price, $filename, $status,$stock) === false){
    return false;
  }
  return regist_item_transaction($db, $name, $price,$status, $image, $filename,$type,$purpose,$stock);
}
//アイテム情報と画像を新規作成する
function regist_item_transaction($db, $name, $price, $status, $image, $filename,$type,$purpose,$stock){
  $db->beginTransaction();
  if(insert_item($db, $name, $price, $filename, $status,$type,$purpose,$stock) 
    && save_image($image, $filename)){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
  
}
//新規アイテム情報を作成する
function insert_item($db, $name, $price,$filename, $status,$type,$purpose,$stock){
  $status_value = PERMITTED_ITEM_STATUSES[$status];
  $sql = "
    INSERT INTO
      ec_item_master(
        name,
        price,
        img,
        status,
        type,
        purpose,
        stock
      )
    VALUES(:name, :price, :filename, :status_value, :type, :purpose,:stock);
  ";
  $array=array(':name' => $name,':price' => $price,':filename' => $filename,':status_value' => $status_value,':type'=>$type,':purpose'=>$purpose,':stock'=>$stock);
  return execute_query($db, $sql,$array);
}

function insert_stock($db,$item_id,$stock){
  $sql = "
    INSERT INTO
      ec_item_stock(
        item_id,
        stock
      )
    VALUES(:item_id,:stock)
    ";
  $array=array('item_id' => $item_id,':stock' =>$stock);
  return execute_query($db, $sql,$array);
}
//アイテムの公開設定を更新する
function update_item_status($db, $item_id, $status){
  $sql = "
    UPDATE
      ec_item_master
    SET
      status = :status
    WHERE
      item_id = :item_id
    LIMIT 1
  ";
  $array=array(':status' => (int)$status,':item_id' => $item_id);
  return execute_query($db, $sql,$array);
}
//アイテムの在庫数を変更する
function update_item_stock($db, $item_id, $stock){
  $sql = "
    UPDATE
      ec_item_master
    SET
      stock = :stock,
      update_datetime = now()
    WHERE
      item_id = :item_id
    LIMIT 1
  ";
  $array=array(':stock' => $stock,'item_id' => $item_id);
  return execute_query($db, $sql,$array);
}

function update_sale_mode($db,$item_id,$sale){
  $sql = "
    UPDATE
      ec_item_master
    SET
      sale = :sale_mode
    WHERE
      item_id = :item_id
    LIMIT 1
  ";
  $array=array(':sale_mode' => (int)$sale,':item_id' => $item_id);
  return execute_query($db, $sql,$array);
}
//指定したアイテム情報と画像を削除する
function destroy_item($db, $item_id){
  $item = get_item($db, $item_id);
  if($item === false){
    return false;
  }
  $db->beginTransaction();
  if(delete_item($db, $item['item_id'])
    && delete_image($item['img'])){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
}
//アイテム情報を削除する
function delete_item($db, $item_id){
  $sql = "
    DELETE FROM
      ec_item_master
    WHERE
      item_id = :item_id
    LIMIT 1
  ";
  $array=array(':item_id' => $item_id);
  return execute_query($db, $sql,$array);
}


// 非DB
//アイテムの公開ステータスが１か判定
function is_open($item){
  return $item['status'] === 0;
}
//アイテム各情報のバリデーション
function validate_item($name, $price,$filename, $status,$stock){
  $is_valid_item_name = is_valid_item_name($name);
  $is_valid_item_price = is_valid_item_price($price);
  $is_valid_item_stock = is_valid_item_stock($stock);
  $is_valid_item_filename = is_valid_item_filename($filename);
  $is_valid_item_status = is_valid_item_status($status);

  return $is_valid_item_name
    && $is_valid_item_price
    && $is_valid_item_stock
    && $is_valid_item_filename
    && $is_valid_item_status;
}
//アイテム名のバリデーション　1文字以上100文字以内
function is_valid_item_name($name){
  $is_valid = true;
  if(is_valid_length($name, ITEM_NAME_LENGTH_MIN, ITEM_NAME_LENGTH_MAX) === false){
    set_error('商品名は'. ITEM_NAME_LENGTH_MIN . '文字以上、' . ITEM_NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}
//アイテムの金額のバリデーション
function is_valid_item_price($price){
  $is_valid = true;
  if(is_positive_integer($price) === false){
    set_error('価格は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}
//アイテムの在庫数のバリデーション
function is_valid_item_stock($stock){
  $is_valid = true;
  if(is_positive_integer($stock) === false){
    set_error('在庫数は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}
//アイテムの画像名のバリデーション
function is_valid_item_filename($filename){
  $is_valid = true;
  if($filename === ''){
    $is_valid = false;
  }
  return $is_valid;
}
//アイテムの公開ステータスのバリデーション　
function is_valid_item_status($status){
  $is_valid = true;
  if(isset(PERMITTED_ITEM_STATUSES[$status]) === false){
    $is_valid = false;
  }
  return $is_valid;
}
//ページ数に従ってitemsテーブルから8件のデータを取得する
function get_item_limit($db,$start){
  $sql = "
    SELECT
      item_id, 
      name,
      stock,
      price,
      image,
      status
    FROM
      items
    LIMIT :start,8
  ";
  $array=array(':start' => $start);
  return fetch_all_query($db, $sql,$array);
}
//itemsテーブルの全ての商品数を取得
function get_total_items($db){
  $sql = "
    SELECT
      COUNT(*)
    FROM
      items
  
  ";
  return fetch_Column($db,$sql);
}

function get_item_asc($db){
  $sql = '
    SELECT 
      img,
      price,
      name,
      stock
    FROM 
      ec_item_master 
    ORDER BY price';
    
  return fetch_all_query($db, $sql);
}

function get_item_desc($db){
  $sql = '
    SELECT 
      img,
      price,
      name,
      stock
    FROM 
      ec_item_master 
    ORDER BY price DESC';
  return fetch_all_query($db, $sql);
}

function get_ranking($db){
  $sql = '
    SELECT  
      ec_number_of_orders.item_id,
      SUM(amount),
      ec_item_master.name,
      img,
      price,
      stock
    FROM 
      ec_number_of_orders 
    INNER JOIN 
      ec_item_master 
    ON ec_number_of_orders.item_id = ec_item_master.item_id 
    
    GROUP BY item_id ORDER BY SUM(amount) DESC LIMIT 5';
  return fetch_all_query($db, $sql);
}

function search_item($db,$key_word){
  $sql = '
    SELECT 
      img,
      price,
      name,
      stock
    FROM 
      ec_item_master 
    WHERE
      name LIKE :key_word

    ';
    $array = array(':key_word'=>'%'.$key_word.'%');
    return fetch_all_query($db, $sql,$array);
}
