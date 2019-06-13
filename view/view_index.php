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
  <div class="topimg">
      <img src="view/img/header.jpeg">
      <p class="catch">Interesting in applying<br>
          knowledge to development.</p>
  </div>
  <section>
    <div class="container">
      <div class="pickup">
      <div class="pickup-1">
        <div class="gaiyou">
          <a href="login.php">
            <i class="fas fa-user-edit"></i>
            <h3>ログイン</h3>
            <p>MyE-commerceを利用するにはログインが必要です。<br>
            ユーザ登録はサインアップ画面で行うことができます。</p>
          </a>
        </div>
      </div>
      <div class="pickup-2">
        <div class="gaiyou">
          <a href="itemlist.php">
            <i class="fas fa-gifts"></i>
            <h3>商品リスト</h3>
            <p>MyE-commerceで扱っている商品のリストです。<br>
            購入したい商品をカートに入れることができます。</p>
          </a>
        </div>
      </div>
      <div class="pickup-3">
        <div class="gaiyou">
          <a href="cart.php">
            <i class="fas fa-shopping-cart"></i>
            <h3>ショッピングカート</h3>
            <p>カートの中身を確認したり、数量を変更したりできます。<br>
            購入画面に移りたい場合は、こちらから進んでください。</p>
          </a>
        </div>
      </div>
    </div>
    </div>
  </section>
  <footer>
    <p>Copyright &copy; Ono All Rights Reserved.</p>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>