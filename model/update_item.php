<?php
// 更新処理
if (count($msg_list) === 0) {
    $sql = "UPDATE `ec_items` 
            SET `price` = :price,`stock`= :stock,`status`= :status, `updated_at`= NOW() WHERE id = :id;";
    $stmt = $pdo->prepare($sql);
    $stmt -> bindValue(":id", $_POST['id'], PDO::PARAM_INT);
    $stmt -> bindValue(":price", $price, PDO::PARAM_INT);
    $stmt -> bindValue(":stock", $stock, PDO::PARAM_INT);
    $stmt -> bindValue(":status", $status, PDO::PARAM_STR);
    if ($stmt -> execute()) {
        $msg_list[] = "商品情報を更新しました。";
    } else {
        $msg_list[] = "商品情報の更新に失敗しました。";
    }
}

