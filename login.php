<?php
session_start();
include("connection.php");

if(isset($_POST['submit'])) {
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE phone = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        if(password_verify($password, $user_data['password'])) {
            $_SESSION['user_id'] = $user_data['id'];
            header("Location: index.php"); // Sửa thành index.php
            exit();
        }
    }
    echo '<script>alert("Đăng nhập thất bại. Số điện thoại hoặc mật khẩu không đúng!"); window.location.href = "login.html";</script>';
}
mysqli_close($con);
?>