<?php
$sql = "SELECT `id`, `name`, `price`, `stock`, `status`, `img` 
        FROM `ec_items` WHERE id = :item_id;";
$stmt = $pdo->prepare($sql);

foreach ($_SESSION['cart'][$user_id] as $item_id => $amount) {
    $stmt -> bindValue(":item_id", $item_id, PDO::PARAM_INT);
    if ($stmt -> execute()) {
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        
        // カート内の個数が在庫数以上のときは調整
        if ($row['stock'] == 0) {
            unset($_SESSION['cart'][$user_id][$row['id']]);
            $msg_list[] = $row['name']."が完売のためカートから削除されました。";
        } else if ($_SESSION['cart'][$user_id][$row['id']] > $row['stock']) {
            $_SESSION['cart'][$user_id][$row['id']] = $row['stock'];
            $msg_list[] = $row['name']."が品切れのため個数が調整されました。";
        }
        // カート内の商品が非公開になったときは削除
        if ($row['status'] !== 'open') {
            unset($_SESSION['cart'][$user_id][$row['id']]);
            $msg_list[] = $row['name']."が非公開のためカートから削除されました。";
        }
    }
    // 商品番号と在庫数を連想配列に保存
    $stocks[$row['id']] = $row['stock'];
    // 商品名と購入数を連想配列に保存
    $buys[$row['name']] = $amount;
}
if (count($_SESSION['cart'][$user_id]) === 0) {
    unset($_SESSION['cart'][$user_id]);
}