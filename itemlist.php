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

$pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);

// カートに商品を追加
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    checkToken();
    
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $item_id = $_POST['id'];
        if (!isNum($item_id)) {
            $msg_list[] = "不正な商品番号が送信されました。";
        }
    } 
    
    if (isset($_POST['amount']) && !empty($_POST['amount'])) {
        $amount = $_POST['amount'];
        if (!isNum($amount)) {
            $msg_list[] = "不正な購入個数が送信されました。";
        }
    }
    
    if (count($msg_list) === 0) {
        $sql = "SELECT `name`, `stock`, `status` FROM `ec_items` WHERE id = :item_id;";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(":item_id", $item_id, PDO::PARAM_INT);
        $stmt -> execute();
        if ($stmt->rowCount() >= 1) {
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
            // 同じ商品が既にカートに存在する場合
            if (isset($_SESSION['cart'][$user_id][$item_id])) {
                $amount += $_SESSION['cart'][$user_id][$item_id];
            }
            // 購入個数が在庫数以下であるかチェック
            if ($amount <= $row['stock']) {
                $_SESSION['cart'][$user_id][$item_id] = $amount;
                $msg_list[] = "カートに商品を追加しました。";
                $msg_list[] = $row['name']."が".$amount."個保存されています。";
            } else {
                $msg_list[] = "購入数に対して在庫数が不足しています。";
            }
        } else {
            $msg_list[] = "該当する商品が見つかりませんでした。";
        }
    }
    
} else {
    setToken();
}

// 商品一覧を取得
$sql = "SELECT `id`, `name`, `price`, `stock`, `status`, `img` 
        FROM `ec_items` WHERE status = 'open';";
$stmt = $pdo->prepare($sql);
$stmt -> execute();

$pdo = null;

if (isset($_SESSION['cart'][$user_id]) && $stmt->rowCount() >= 1) {
    $myCart = $_SESSION['cart'][$user_id];
}

include_once 'view/view_itemlist.php';

?>