<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>MyE-commerce</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
  <link rel="stylesheet" href="view/css/styles.css">
</head>

<body>
  <header>
    <div class="container">
      <div class="header-box">
        <div class="title">
          <h2><i class="fas fa-braille"></i><a href='index.php'>MyE-commerce</a></h2>
        </div>
        <div class="header-nav">
          <button id="menubtn">
            <i class="fas fa-bars"></i><span>MENU</span>
          </button>
          <nav class="menu" id="menu">
            <ul>
                <li><a href="index.php">Top</a></li>
                <li><a href="signup.php">Sign up</a></li>
                <?php if (isset($_SESSION["admin"]) && $_SESSION["admin"]) { ?>
                <li><a href="itemmgr.php">Item Mgr</a></li>
                <li><a href="usermgr.php">User Mgr</a></li>
                <?php } ?>
                <?php if (isset($_SESSION["id"])) { ?>
                <li><a href="itemlist.php">Items</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="logout.php">Log out</a></li>
                <?php } ?>
                <?php if (!isset($_SESSION["id"])) { ?>
                <li><a href="login.php">Log in</a></li>
                <?php } ?>
                <li><a href="../index.html">MyPortfolio</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>
  <section>
    <div class="container">
      <h1>ショッピングカート</h1>
      <?php if (count($msg_list) !== 0) { ?>
      <ul class="msg">
          <?php foreach ($msg_list as $msg) { echo "<li>".h($msg)."</li>"; } ?>
      </ul>
      <?php } ?>
      <div class='line'></div>
      <div class='memo'>
          <ul>
              <li>商品の在庫数を超える個数をカートに入れることはできません。</li>
              <li>商品の公開状況や在庫数が更新された場合、カートから自動的に削除されます。</li>
              <li>購入直前に商品情報が更新された場合、処理を中断してカート画面に戻ります。</li>
          </ul>
      </div>
      <div class='line'></div>
      <?php if (isset($_SESSION['cart'][$user_id])) { ?>
      <table class='item_mgr'>
          <tr>
              <th>商品画像</th>
              <th>商品名</th>
              <th>価格</th>
              <th>削除</th>
              <th>数量</th>
          </tr>
          <?php 
          $totalFee = 0;
          $myCart = $_SESSION['cart'][$user_id];
          foreach ($myCart as $item_id => $amount) {
            $stmt -> bindValue(":item_id", $item_id, PDO::PARAM_INT);
            $stmt -> execute();
            if ($stmt->rowCount() >= 1) {
                $row = $stmt -> fetch(PDO::FETCH_ASSOC);
                $totalFee += $row['price'] * $amount;
          ?>
          <tr>
              <td><div class='img_frame'><img src='<?php echo STORE.h($row['img']); ?>'></div></td>
              <td><?php echo h($row['name']); ?></td>
              <td><?php echo h($row['price']); ?>円</td>
              <td>
                  <form action="cart.php" method="post">
                    <input type='hidden' name='type' value='delete'>
                    <input type='hidden' name='delete_id' value="<?php echo h($row['id']); ?>" >
                    <input type='hidden' name='token' value="<?php echo h($_SESSION['token']); ?>">
                    <input type='submit' value='削除'>
                  </form> 
              </td>
              
              <td>
                  <form action="cart.php" method="post">
                    <select name='amount' class='number'><?php setOption(1, $row['stock'], $amount); ?></select>
                    <input type='hidden' name='type' value='update'>
                    <input type='hidden' name='id' value="<?php echo h($row['id']); ?>">
                    <input type='hidden' name='token' value="<?php echo h($_SESSION['token']); ?>">
                    <input type='submit' value='変更'>
                  </form> 
              </td>
          </tr>
            <?php } ?>
          <?php } ?>
      </table>
      <div class='line'></div>
      <div class='total'>合計金額：<?php echo $totalFee; ?>円</div>
      <?php } else { echo '<p>現在カート内に商品はありません。';} ?>
      
      <a href='result.php' class='btn <?php if (!isset($_SESSION['cart'][$user_id])) {echo 'inactive';} ?>'>購入に進む</a>
    </div>
  </section>
  <footer>
    <p>Copyright &copy; Ono All Rights Reserved.</p>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>