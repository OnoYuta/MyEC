<?php

if ($_POST['type'] === 'insert') {
    // 商品名
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $name = $_POST['name'];
        if (mb_strlen($name, 'UTF-8') > 20) {
            // var_dump(mb_strlen($name));
            $msg_list[] = "商品名は20文字以下で入力してください。";
        }
    } else {
        $msg_list[] = "商品名を入力してください。";
    }
    
    // 商品画像
    if (isset($_FILES['img']) && !empty($_FILES['img']['name'])) {
        $temp_name = $_FILES['img']['tmp_name'];
        //MIMEタイプの取得
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $temp_name);
        finfo_close($finfo);
        //png以外かつjpeg以外のファイルが選択されたとき
        if (($mime_type !== 'image/png') && ($mime_type !== 'image/jpeg')) {
            $msg_list[] = '商品画像にはpngもしくはjpegのみ使用できます。';
        }
    } else {
        $msg_list[] = "商品画像が選択されていません。";
    }
}

// 価格
if (isset($_POST['price']) && $_POST['price'] !== '') {
    $price = $_POST['price'];
    if (preg_match('/^[0-9]+$/',$price)) {
        if ($price < 0 || 999999 < $price) {
            $msg_list[] = "価格は0以上1,000,000未満の値を入力してください。";
        }
    } else {
        $msg_list[] = "価格は半角数字で0以上の値を入力してください。";
    }
} else {
    $msg_list[] = "価格を入力してください。";
}

// 在庫数
if (isset($_POST['stock']) && $_POST['stock'] !== '') {
    $stock = $_POST['stock'];
    if (preg_match('/^[0-9]+$/',$stock)) {
        if ($stock < 0 || 999999 < $stock) {
            $msg_list[] = "在庫数は0以上1,000,000未満の値を入力してください。";
        }
    } else {
        $msg_list[] = "在庫数は半角数字で0以上の値を入力してください。";
    }
} else {
    $msg_list[] = "在庫数を入力してください。";
}

// 公開状況(0,1でやっても良い)
if (isset($_POST['status']) && !empty($_POST['status'])) {
    $status = $_POST['status'];
    if ($status !== 'open' && $status !== 'close') {
        $msg_list[] = "公開状況の値が不正です。";
    }
} else {
    $msg_list[] = "公開状況が選択されていません。";
}