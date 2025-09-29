<?php
require 'db.php';
$search = $_GET['q'] ?? '';
$sql = "SELECT * FROM products";
if($search) $sql .= " WHERE name LIKE '%".$conn->real_escape_string($search)."%'";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Shop Đàn TB</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<header class="top-bar">
  <div class="logo">Shop Đàn Tuấn Bo</div>
  <form class="search" method="get">
    <input type="text" name="q" placeholder="Tìm sản phẩm..." value="<?=htmlspecialchars($search)?>">
    <button><i class="fa fa-search"></i></button>
  </form>
  <div class="cart"><a href="cart.php"><i class="fa fa-shopping-cart"></i></a></div>
</header>

<nav class="main-menu">
  <a href="index.php">Trang chủ</a>
  <a href="products.php">Sản phẩm</a>
  <a href="contact.php">Liên hệ</a>
</nav>

<main class="container">
  <section class="banner">
      <img src="img/1111.webp">
  </section>
  <h2>Sản phẩm nổi bật</h2>
  <div class="product-grid">
    <?php while($p=$res->fetch_assoc()): ?>
      <div class="item">
        <img src="img/<?=htmlspecialchars($p['image'] ?: 'no-image.png')?>">  
        <h3><?=htmlspecialchars($p['name'])?></h3>
        <p class="price"><?=number_format($p['price'])?> đ</p>
        <a class="btn" href="cart.php?add=<?=$p['id']?>">Thêm vào giỏ</a>
      </div>
    <?php endwhile; ?>
  </div>
</main>

<footer>© 2025 Tuấn dz</footer>
</body>
</html>