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
      <h1>ユーザ登録</h1>
      <?php if (count($msg_list) !== 0) { ?>
      <ul class="msg">
          <?php foreach ($msg_list as $msg) { echo "<li>".h($msg)."</li>"; } ?>
      </ul>
      <?php } ?>
      <div class='line'></div>
      <div class='memo'>
          <ul>
              <li>「半角英数字のみ」かつ「６文字以上」で入力してください。</li>
              <li>他のユーザが使用しているユーザ名は使用できません。</li>
              <li>管理者は［ユーザ名: admin , パスワード: admin］です。</li>
          </ul>
      </div>
      <div class='line'></div>
      <form method='post'>
          <table>
              <tr><td>ユーザ名</td><td>：<input type='text' name='name'></td></tr>
              <tr><td>パスワード</td><td>：<input type='password' name='password'></td></tr>
              <input type='hidden' name='token' value="<?php echo h($_SESSION['token']); ?>">
              <tr><td><input type='submit' value='登録'></td></tr>
          </table>
      </form>
    </div>
  </section>
  <footer>
    <p>Copyright &copy; Ono All Rights Reserved.</p>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>