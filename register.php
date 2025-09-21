<?php
include("connection.php");

if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $password = $_POST['password'];

    if(empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($phone) || empty($password)) {
        echo '<script>alert("Vui lòng điền đúng và đủ thông tin!"); window.history.back();</script>';
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $check_sql = "SELECT * FROM users WHERE phone = '$phone' OR email = '$email'";
    $check_result = mysqli_query($con, $check_sql);

    if(mysqli_num_rows($check_result) > 0) {
        echo '<script>alert("Số điện thoại hoặc email đã được sử dụng!"); window.history.back();</script>';
        exit();
    }

    $sql = "INSERT INTO users (name, email, country, phone, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $country, $phone, $hashed_password);

    if(mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Đăng ký thành công! Vui lòng đăng nhập."); window.location.href = "login.html";</script>';
    } else {
        echo '<script>alert("Đã có lỗi xảy ra. Vui lòng thử lại."); window.history.back();</script>';
    }
    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>