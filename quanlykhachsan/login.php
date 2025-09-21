<?php
// Bắt đầu session để lưu trạng thái đăng nhập
session_start();

// Bao gồm tệp kết nối
include("connection.php");

// Kiểm tra xem form đã được gửi đi chưa
if(isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $username = mysqli_real_escape_string($con, $_POST['usname']);
    $password = mysqli_real_escape_string($con, $_POST['pass']);

    // Tạo câu lệnh SQL để tìm người dùng
    $sql = "SELECT * FROM login WHERE usname = '$username' AND pass = '$password'";

    // Đổi mysql_query thành mysqli_query
    $result = mysqli_query($con, $sql);

    // Đổi mysql_num_rows thành mysqli_num_rows
    $count = mysqli_num_rows($result);

    if($count > 0) {
        // Nếu tìm thấy người dùng, lưu tên vào session và chuyển hướng
        $_SESSION['user'] = $username;
        header("Location: index.html"); // Hoặc trang dashboard của admin
        exit();
    } else {
        // Nếu không, hiển thị thông báo lỗi
        echo '<script>
                alert("Đăng nhập thất bại. Tên đăng nhập hoặc mật khẩu không đúng!");
                window.location.href = "login.html";
              </script>';
    }

    // Đóng kết nối
    mysqli_close($con);
}
?>
