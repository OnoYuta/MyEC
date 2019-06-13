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
} else {
    $user_id = $_SESSION['id'];
}

// カート内容を変更する場合
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['type'])) {
    
    checkToken();
    
    if ($_POST['type'] === 'delete' && isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        if (isNum($delete_id)) {
            unset($_SESSION['cart'][$user_id][$delete_id]);
            $msg_list[] = 'カート内の商品を削除しました。';
        } else {
            $msg_list[] = '不正な商品番号が送信されました。';
        }
    }
    
    if ($_POST['type'] === 'update' && isset($_POST['id']) && isset($_POST['amount'])) {
        
        $item_id = $_POST['id'];
        $amount = $_POST['amount'];
        
        if (isNum($item_id) && isNum($amount)) {
            $_SESSION['cart'][$user_id][$item_id] = $amount;
            $msg_list[] = "カート内の商品の個数を変更しました。";
        } else {
            $msg_list[] = '送信情報が不正です。';
        }
    }
    
} else {
    setToken();
}



// 品切れと非公開商品のチェック
if (isset($_SESSION['cart'][$user_id])) {
    $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
    require_once 'model/checkStockAndClosed.php';
}

include_once 'view/view_cart.php';

$pdo = null;

?>