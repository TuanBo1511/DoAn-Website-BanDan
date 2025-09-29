<?php
require 'db.php';
// thêm
if($_SERVER['REQUEST_METHOD']=='POST'){
  $name = $_POST['name'];
  $price= $_POST['price'];
  $desc = $_POST['description'];
  $img  = '';
  if(!empty($_FILES['image']['name'])){
      $img = time().'_'.basename($_FILES['image']['name']);
      if (move_uploaded_file($_FILES['image']['tmp_name'],'img/'.$img)) { // Thay đổi ở đây
        // Tải lên thành công
      } else {
        // Tải lên thất bại
        echo "Lỗi: Không thể tải lên ảnh."; // In ra thông báo lỗi
      }
  }
  $stmt = $conn->prepare("INSERT INTO products(name,price,description,image) VALUES (?,?,?,?)");
  $stmt->bind_param("sdss",$name,$price,$desc,$img);
  $stmt->execute();
}
// xóa
if(isset($_GET['del'])){
  $id = (int)$_GET['del'];
  $conn->query("DELETE FROM products WHERE id=$id");
}
$res=$conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8"><title>Quản lý sản phẩm</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="top-bar">
  <div class="logo">Quản lý sản phẩm</div>
  <div class="cart"><a href="cart.php"><i class="fa fa-shopping-cart"></i></a></div>
</header>
<nav class="main-menu">
  <a href="index.php">Trang chủ</a>
  <a href="products.php">Sản phẩm</a>
  <a href="contact.php">Liên hệ</a>
</nav>

<main class="container">
  <h2>Thêm sản phẩm mới</h2>
  <form class="add-product" method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Tên sản phẩm" required>
    <input type="number" step="0.01" name="price" placeholder="Giá" required>
    <textarea name="description" placeholder="Mô tả"></textarea>
    <input type="file" name="image" accept="image/*">
    <button class="btn">Thêm</button>
  </form>

  <h2>Danh sách sản phẩm</h2>
  <div class="product-grid">
    <?php while($p=$res->fetch_assoc()): ?>
    <div class="item">
      <img src="img/<?=htmlspecialchars($p['image'] ?: 'no-image.png')?>">
      <h3><?=htmlspecialchars($p['name'])?></h3>
      <p class="price"><?=number_format($p['price'])?> đ</p>
      <p><?=htmlspecialchars($p['description'])?></p>
      <div class="product-actions">
          <a class="btn" href="?del=<?=$p['id']?>" onclick="return confirm('Xóa?')">Xóa</a>
          <a class="btn" href="edit.php?id=<?=$p['id']?>">Sửa</a>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</main>
<footer>© 2025 Tuấn dz</footer>
</body>
</html>