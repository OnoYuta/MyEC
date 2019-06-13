<?php

// CSRF対策
function setToken() {
  $token = sha1(uniqid(mt_rand(), true));
  $_SESSION['token'] = $token;
}

function checkToken() {
  if (empty($_SESSION['token']) || ($_SESSION['token']) != $_POST['token']) {
    echo "不正なPOSTが行われました。";
    exit;
  }
}

function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
}

function isNum($num) {
    if (preg_match('/^[0-9]+$/', $num)) {
        return true;
    } else {
        return false;
    }
}

function setOption($min, $max, $selected) {
    if ($max < $selected) {
        $selected = $max;
    }
    for ($i = $min; $i <= $max; $i++) {
        if ($i == $selected) {
            echo "<option value='".$i."' selected>".$i."</option>";
        } else {
            echo "<option value='".$i."'>".$i."</option>";
        }
    }
}