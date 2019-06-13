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
      <h1>アイテム一覧</h1>
      <?php if (count($msg_list) !== 0) { ?>
      <ul class="msg">
          <?php foreach ($msg_list as $msg) { echo "<li>".h($msg)."</li>"; } ?>
      </ul>
      <?php } ?>
      <div class='line'></div>
      <div class='memo'>
          <ul>
              <li>管理者によって非公開に設定されている商品はこのページに表示されません。</li>
              <li>商品の在庫数を超える個数をカートに入れることはできません。</li>
              <li>商品の公開状況や在庫数が更新された場合、カートから自動的に削除されます。</li>
          </ul>
      </div>
      <div class='line'></div>
      <div class='itemlist'>
          <?php if ($stmt->rowCount() >= 1) { ?>
            <?php while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { ?>
            <?php 
            // 残りの在庫数を計算
            $remain = $row['stock'];
            if (isset($myCart[$row['id']])) {
                    $remain -= $myCart[$row['id']];
                }
            ?>
            <form action='itemlist.php' method='post'>
                <input type='hidden' name='id' value=<?php echo h($row['id']); ?>>
                <?php if ($remain >= 1) { ?>
                    <div class="sale">
                <?php } else { ?>
                    <div class="sold">
                <?php } ?>
                    <ul>
                        <li><div class='img_frame'><img src='<?php echo STORE.h($row['img']); ?>'></div></li>
                        <li><?php echo h($row['name']); ?></li>
                        <li><?php echo h($row['price']); ?>円</li>
                        <li>
                            <select name='amount' class='number'><?php setOption(0, $remain, 0); ?></select>
                            <input type='submit' value='カートに入れる' <?php if ($remain == 0) { echo 'disabled'; } ?>>
                        </li>
                    </ul>
                </div>
                <input type='hidden' name='token' value="<?php echo h($_SESSION['token']); ?>">
            </form>
            <?php } ?>
        </div>
        <a href='cart.php' class='btn'>購入に進む</a>
      <?php }else { ?>
        <p>現在公開されている商品はありません。</p>
      <?php } ?>
    </div>
  </section>
  <footer>
    <p>Copyright &copy; Ono All Rights Reserved.</p>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>