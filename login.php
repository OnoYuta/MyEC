<?php
require_once 'config/config.php';
require_once 'model/model.php';

$msg_list = array();

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['id'])) {
    // ログイン済みのユーザはログアウトさせる
    header( "Location: ".HOST_NAME.LOGOUT);
	exit ;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    checkToken();
    
    if (isset($_POST['name']) && !empty($_POST['name']) && 
    isset($_POST['password']) && !empty($_POST['password'])) {
        
        $name = $_POST['name'];
        $password = $_POST['password'];
        
        // 該当するユーザが存在するかチェック
        if (count($msg_list) === 0){
            
            $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
            
            $sql = "SELECT id, name, admin FROM ec_users 
                    WHERE name = '".$name."' AND password = '".$password."';";
            // var_dump($sql);
            $stmt = $pdo->prepare($sql);
            $stmt -> execute();
            
            if ($stmt->rowCount() === 1) {
                $msg_list[] = $name."としてログインしました。";
                $row = $stmt -> fetch(PDO::FETCH_ASSOC);
                $_SESSION["id"] = $row["id"];
                $_SESSION["name"] = $row["name"];
                $_SESSION["admin"] = $row["admin"];
            } else {
                $msg_list[] = "条件に一致するユーザは登録されていません。";
            }
            $pdo = null;
        }
        
    } else {
        $msg_list[] = "ユーザ名とパスワードを入力してください。";
    }

} else {
  setToken();
}

include_once 'view/view_login.php';

?>