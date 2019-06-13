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

// ユーザ情報の削除
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    checkToken();
    
    if (isset($_POST['delete_id']) && !empty($_POST['delete_id'])){
        $delete_id = $_POST['delete_id'];
        if ($_SESSION['id'] === $delete_id) {
            $msg_list[] = "自身を削除することはできません。";
        } else {
            $sql = "DELETE FROM ec_users WHERE id = :delete_id;";
            $stmt = $pdo->prepare($sql);
            $stmt -> bindValue(":delete_id", $delete_id, PDO::PARAM_INT);
            if ($stmt -> execute()) {
                $msg_list[] = "ユーザ情報の削除に成功しました。";
            } else {
                $msg_list[] = "ユーザ情報の削除に成功しました。";
            }
        }
    }
} else {
    setToken();
}

// ユーザ情報一覧を取得
$sql = "SELECT id, name, created_at, admin FROM ec_users;";
$stmt = $pdo->prepare($sql);
$stmt -> execute();

$pdo = null;

include_once 'view/view_usermgr.php';

?>