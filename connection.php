<?php
// Tên máy chủ, thường là localhost
$servername = "localhost:3307"; // QUAN TRỌNG: Thêm cổng 3307 mà chúng ta đã đổi
// Tên người dùng database, mặc định của XAMPP là 'root'
$username = "root";
// Mật khẩu database, mặc định của XAMPP là để trống
$password = "";
// Tên database bạn đã tạo
$dbname = "hotel";

// Sử dụng hàm mysqli_connect() thay cho mysql_connect() đã lỗi thời
$con = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$con) {
    // Dừng chương trình và hiển thị lỗi nếu không thể kết nối
    die("Connection failed: " . mysqli_connect_error());
}
?>
