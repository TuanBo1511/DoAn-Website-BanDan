<?php
require 'db.php'; // Kết nối CSDL

$id = (int)$_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
if (!$product) {
    echo "Không tìm thấy sản phẩm!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $desc  = $_POST['description'];
    $imgName = $product['image']; // giữ ảnh cũ nếu không upload mới

    if (!empty($_FILES['image']['name'])) {
        $imgName = time().'_'.basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], 'img/'.$imgName)) {
            echo "Lỗi: Không thể tải lên ảnh.";
            exit;
        }
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("sdssi", $name, $price, $desc, $imgName, $id);
    if ($stmt->execute()) {
        header("Location: products.php");
        exit;
    } else {
        echo "Lỗi: Không thể cập nhật sản phẩm.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa sản phẩm</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="top-bar">
  <div class="logo">Quản lý sản phẩm</div>
</header>

<nav class="main-menu">
  <a href="index.php">Trang chủ</a>
  <a href="products.php">Sản phẩm</a>
  <a href="contact.php">Liên hệ</a>
</nav>

<main class="container">
  <h2>Cập nhật sản phẩm</h2>
  <form class="add-product" method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Tên sản phẩm" 
           value="<?=htmlspecialchars($product['name'])?>" required>

    <input type="number" step="0.01" name="price" placeholder="Giá" 
           value="<?=htmlspecialchars($product['price'])?>" required>

    <textarea name="description" placeholder="Mô tả"><?=htmlspecialchars($product['description'])?></textarea>

    <input type="file" name="image" accept="image/*">

    <?php if ($product['image']): ?>
      <div style="margin:10px 0;">
        <img src="img/<?=htmlspecialchars($product['image'])?>" width="150" alt="Ảnh sản phẩm">
      </div>
    <?php endif; ?>

    <button class="btn">Lưu thay đổi</button>
  </form>
</main>

<footer>© 2025 Tuấn dz</footer>
</body>
</html>
