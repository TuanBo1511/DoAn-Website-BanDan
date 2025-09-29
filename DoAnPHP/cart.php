<?php
session_start();
require 'db.php';
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Thêm
if(isset($_GET['add'])){
  $id=(int)$_GET['add'];
  $_SESSION['cart'][$id] = ($_SESSION['cart'][$id]??0)+1;
  header('Location: cart.php');
  exit;
}

// Lấy chi tiết
$items=[];
if($_SESSION['cart']){
  $ids = implode(',',array_keys($_SESSION['cart']));
  $items = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8"><title>Giỏ hàng</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="top-bar">
  <div class="logo">Shop Đàn Tuấn Bo</div>
</header>
<nav class="main-menu">
  <a href="index.php">Trang chủ</a>
  <a href="products.php">Sản phẩm</a>
  <a href="contact.php">Liên hệ</a>
</nav>
<main class="container">
  <h2>Giỏ hàng</h2>
  <?php if(!$items): ?>
     <p>Giỏ hàng trống.</p>
  <?php else: ?>
     <ul>
     <?php $total=0; while($p=$items->fetch_assoc()): 
           $qty = $_SESSION['cart'][$p['id']];
           $subtotal = $qty * $p['price'];
           $total += $subtotal;
     ?>
        <li><?=htmlspecialchars($p['name'])?> x <?=$qty?> = <?=number_format($subtotal)?> đ</li>
     <?php endwhile; ?>
     </ul>
     <p><strong>Tổng: <?=number_format($total)?> đ</strong></p>
  <?php endif; ?>
</main>
<footer>© 2025 Tuấn dz</footer>
</body>
</html>
