<?php
require_once 'config/config.php';
require_once 'model/model.php';

$msg_list = array();

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header("Location: ".HOST_NAME.LOGOUT);
	exit;
} else if (!isset($_SESSION['cart'][$_SESSION['id']])){
    header("Location: ".HOST_NAME.CART);
	exit;
} else {
    $user_id = $_SESSION['id'];
}

// 品切れと非公開商品のチェック
$pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
require_once 'model/checkStockAndClosed.php';

// 内容に調整があった場合はカート画面に戻る
if (count($msg_list) !== 0) {
    include_once 'view/view_cart.php';
    $pdo = null;
    exit;
}

//トランザクション処理を開始
$pdo->beginTransaction();

try {
    foreach ($_SESSION['cart'][$user_id] as $item_id => $amount) {
        // 在庫数を更新
        $sql = "UPDATE `ec_items` SET `stock`= :stock, `updated_at`= NOW() 
                WHERE id = :item_id;";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(":stock", $stocks[$item_id] - $amount, PDO::PARAM_INT);
        $stmt -> bindValue(":item_id", $item_id, PDO::PARAM_INT);
        if (!$stmt -> execute()) {
            $msg_list[] = 'アップデート失敗';
        }
    }
    foreach ($_SESSION['cart'][$user_id] as $item_id => $amount) {
        // 購入結果を記録
        $sql = "INSERT INTO `ec_buys`( `user_id`, `item_id`, `amount`, `created_at`) 
                VALUES (:user_id, :item_id, :amount, NOW());";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $stmt -> bindValue(":item_id", $item_id, PDO::PARAM_INT);
        $stmt -> bindValue(":amount", $amount, PDO::PARAM_INT);
        if (!$stmt -> execute()) {
            $msg_list[] = 'インサート失敗';
        }
    }
    //コミット
    $pdo->commit();
} catch (PDOException $e) {
    
    //ロールバック
    $pdo->rollback();
    echo $e->getMessage();
}


// カートを空にする
unset($_SESSION['cart'][$user_id]);
$pdo = null;

include_once 'view/view_result.php';

?>