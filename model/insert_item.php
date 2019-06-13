<?php
    
// 登録処理
if (count($msg_list) === 0) {
    // 画像をアップロード
    $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
    $img_name = "i".uniqid().".".$ext;
    if ($_FILES['img']['error'] === UPLOAD_ERR_OK) {
        move_uploaded_file($temp_name, STORE.$img_name);
    } else {
        $msg_list[] = '画像アップロード失敗';
    }
    // 新規商品をINSERT
    $sql = "INSERT INTO ec_items(name, price, stock, status, img, created_at, updated_at) 
            VALUES (:name, :price, :stock, :status, :img_name, NOW(), NOW());";
    $stmt = $pdo->prepare($sql);
    $stmt -> bindValue(":name", $name, PDO::PARAM_STR);
    $stmt -> bindValue(":price", $price, PDO::PARAM_INT);
    $stmt -> bindValue(":stock", $stock, PDO::PARAM_INT);
    $stmt -> bindValue(":status", $status, PDO::PARAM_STR);
    $stmt -> bindValue(":img_name", $img_name, PDO::PARAM_STR);
    if ($stmt -> execute()) {
        $msg_list[] = "「".$name."」を新規商品として登録しました。";
    } else {
        $msg_list[] = "「".$name."」の登録に失敗しました。";
    }
}