<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'product_db';     // đã tạo sẵn
$conn = new mysqli($host,$user,$pass,$db);
if($conn->connect_error){ die("Kết nối thất bại: ".$conn->connect_error); }
$conn->set_charset('utf8mb4');
?>
