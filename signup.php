<?php
require_once 'config/config.php';
require_once 'model/model.php';

$msg_list = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    checkToken();
    
    if (isset($_POST['name']) && !empty($_POST['name']) && 
    isset($_POST['password']) && !empty($_POST['password'])) {
        
        $name = $_POST['name'];
        $password = $_POST['password'];
        
        
        // 入力値のチェック
        if (strlen($name) < 6) {
            $msg_list[] = "ユーザ名は６文字以上で入力してください。";
        }
        if (strlen($password) < 6) {
            $msg_list[] = "パスワードは６文字以上で入力してください。";
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
            $msg_list[] = "ユーザ名は半角英数字のみ使用できます。";
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
            $msg_list[] = "パスワードは半角英数字のみ使用できます。";
        }
        
        // ユーザ名の重複チェック
        if (count($msg_list) === 0){
            $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
            
            $sql = "SELECT name FROM ec_users WHERE name = '".$name."';";
            $stmt = $pdo->prepare($sql);
            $stmt -> execute();
            
            if ($stmt->rowCount() === 0) {
                $sql = "INSERT INTO ec_users(name, password, created_at, updated_at) 
                    VALUES (:name, :password, NOW(), NOW());";
                $stmt = $pdo->prepare($sql);
                $stmt -> bindValue(":name", $name, PDO::PARAM_STR);
                $stmt -> bindValue(":password", $password, PDO::PARAM_STR);
                if ($stmt -> execute()) {
                    $msg_list[] = "「".$name."」を新規ユーザとして登録しました。";
                } else {
                    $msg_list[] = "ユーザ登録に失敗しました。";
                }
            } else {
                $msg_list[] = "そのユーザ名は既に使用されています。";
            }
            
            $pdo = null;
        }
        
    } else {
        $msg_list[] = "ユーザ名とパスワードを入力してください。";
    }

} else {
  setToken();
}

include_once 'view/view_signup.php';

?>