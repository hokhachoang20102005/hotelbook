<?php
// Bao gồm tệp kết nối đã được sửa
include("connection.php");

// Kiểm tra xem form đã được gửi đi chưa
if(isset($_POST['submit'])) {
    // Lấy dữ liệu từ form và làm sạch để tránh lỗi SQL Injection cơ bản
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $room_type = mysqli_real_escape_string($con, $_POST['troom']);
    $num_adults = mysqli_real_escape_string($con, $_POST['adults']);
    $num_children = mysqli_real_escape_string($con, $_POST['children']);
    $check_in = mysqli_real_escape_string($con, $_POST['cin']);
    $check_out = mysqli_real_escape_string($con, $_POST['cout']);

    // Tạo câu lệnh SQL để chèn dữ liệu
    $sql = "INSERT INTO customer (name, email, country, phone, room_type, num_adults, num_children, check_in, check_out) 
            VALUES ('$name', '$email', '$country', '$phone', '$room_type', '$num_adults', '$num_children', '$check_in', '$check_out')";

    // Đổi mysql_query thành mysqli_query và thêm biến kết nối $con
    $result = mysqli_query($con, $sql);

    if($result) {
        // Nếu thành công, chuyển hướng đến trang thanh toán
        header("Location: payment.html");
        exit(); // Dừng thực thi sau khi chuyển hướng
    } else {
        // Nếu có lỗi, hiển thị thông báo lỗi chi tiết
        echo "Lỗi: " . mysqli_error($con);
    }

    // Đóng kết nối
    mysqli_close($con);
}
?>
