<?php
require_once 'config/config.php';
require_once 'model/model.php';

$msg_list = array();

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id']) || $_SESSION["admin"] === FALSE) {
    header("Location: ".HOST_NAME.LOGOUT);
	exit;
}

$pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    checkToken();
    
    // 新規商品登録
    if (isset($_POST['type']) && $_POST['type'] === 'insert') {
        require_once 'model/checkValueItemMgr.php';
        require_once 'model/insert_item.php';
    }
    
    // 商品情報変更
    if (isset($_POST['type']) && $_POST['type'] === 'update') {
        require_once 'model/checkValueItemMgr.php';
        require_once 'model/update_item.php';
    }
    
    // 商品情報削除
    if (isset($_POST['type']) && $_POST['type'] === 'delete') {
        $delete_id = $_POST['delete_id'];
        $sql = "DELETE FROM ec_items WHERE id = :delete_id;";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(":delete_id", $delete_id, PDO::PARAM_INT);
        if ($stmt -> execute()) {
            $msg_list[] = "商品情報を削除しました。";
        } else {
            $msg_list[] = "商品情報の削除に失敗しました。";
        }
    }

} else {
  setToken();
}

// 商品リストを取得
$sql = "SELECT `id`, `name`, `price`, `stock`, `status`, `img` FROM `ec_items`；";
$stmt = $pdo->prepare($sql);
$stmt -> execute();

$pdo = null;

include_once 'view/view_itemmgr.php';

?>