<?php

require_once 'config/config.php';

if (!isset($_SESSION)) {
    session_start();
}

$session_name = session_name();
$_SESSION = array();

if(isset($_COOKIE[$session_name])){
    $params = session_get_cookie_params();
    setcookie($session_name, '', time() - 3600,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

header( "Location: ".HOST_NAME.LOGIN);
exit;

?>