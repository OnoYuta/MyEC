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
      <h1>商品管理</h1>
      <?php if (count($msg_list) !== 0) { ?>
      <ul class="msg">
          <?php foreach ($msg_list as $msg) { echo "<li>".h($msg)."</li>"; } ?>
      </ul>
      <?php } ?>
      <div class='line'></div>
      <div class='memo'>
          <ul>
              <li>このページにアクセスできるのは管理者権限を持つユーザのみです。</li>
              <li>権限のないユーザがアクセスした場合は、自動的にログアウトされます。</li>
              <li>価格または在庫数にマイナスの値を入力することはできません。</li>
              <li>商品画像として使用できる画像ファイル形式はPNGとJPEGのみです。</li>
          </ul>
      </div>
      <div class='line'></div>
      <h2>新規商品を登録する</h2>
      <form action='itemmgr.php' method='post' enctype='multipart/form-data'>
          <input type='hidden' name='type' value='insert'>
          <table>
              <tr><td>商品名</td><td>：<input type='text' name='name'></td></tr>
              <tr><td>価格</td><td>：<input type='number' name='price'>円</td></tr>
              <tr><td>在庫数</td><td>：<input type='number' name='stock'>個</td></tr>
              <tr><td>公開状況</td><td>：
              <select name='status'>
                  <option value='open'>公開</option>
                  <option value='close'>非公開</option>
              </select>
              </td></tr>
              <tr><td>商品画像</td><td>：<input type='file' name='img' accept="image/png,image/jpeg"></td></tr>
              <tr><input type='hidden' name='token' value="<?php echo h($_SESSION['token']); ?>">
              <td><input type='submit' value='登録'></td>
          </table>
      </form>
      <div class='line'></div>
      <h2>商品情報を変更する</h2>
      <?php if ($stmt->rowCount() >= 1) { ?>
          <table class='item_mgr'>
              <tr>
                  <th>商品画像</th>
                  <th>商品名</th>
                  <th>価格</th>
                  <th>在庫数</th>
                  <th>公開状況</th>
                  <th>更新</th>
                  <th>削除</th>
              </tr>
              <?php while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { ?>
              <tr <?php if ($row["status"] === 'open') {echo 'class="open"';} else {echo 'class="close"';} ?>>
                  <form action='itemmgr.php' method='post'>
                      <input type='hidden' name='type' value='update'>
                      <input type='hidden' name='id' value=<?php echo h($row["id"]); ?>>
                      <td><div class="img_frame"><img src='<?php echo STORE.$row['img']; ?>'></div></td>
                      <td><?php echo h($row["name"]); ?></td>
                      <td><input type='number' name='price' value=<?php echo h($row["price"]); ?>>円</td>
                      <td><input type='number' name='stock' value=<?php echo h($row["stock"]); ?>>個</td>
                      <td>
                          <select name='status'>
                              <option value='open' <?php if ($row["status"] === 'open') {echo "selected";} ?>>公開</option>
                              <option value='close' <?php if ($row["status"] === 'close') {echo "selected";} ?>>非公開</option>
                          </select>
                      </td>
                      <input type='hidden' name='token' value="<?php echo h($_SESSION['token']); ?>">
                      <td><input type='submit' value='更新'></td>
                  </form>
                  <td>
                      <form action="itemmgr.php" method="post">
                        <input type='hidden' name='type' value='delete'>
                        <input type='hidden' name='delete_id' value=<?php echo h($row["id"]); ?>>
                        <input type='hidden' name='token' value="<?php echo h($_SESSION['token']); ?>">
                        <input type='submit' value='削除'>
                      </form> 
                  </td>
              </tr>
              <?php } ?>
          </table>
      <?php } else { ?>
      <p>登録されている商品はありません。</p>
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