<?php
// Bao gồm tệp kết nối
include("connection.php");

// Kiểm tra xem form đã được gửi đi chưa
if(isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $card_type = mysqli_real_escape_string($con, $_POST['card_type']);
    $card_no = mysqli_real_escape_string($con, $_POST['card_no']);
    $cvv = mysqli_real_escape_string($con, $_POST['cvv']);
    $exp_date = mysqli_real_escape_string($con, $_POST['exp_date']);

    // Tạo câu lệnh SQL
    $sql = "INSERT INTO payment (name, email, phone, card_type, card_no, cvv, exp_date) 
            VALUES ('$name', '$email', '$phone', '$card_type', '$card_no', '$cvv', '$exp_date')";

    // Đổi mysql_query thành mysqli_query
    $result = mysqli_query($con, $sql);

    if($result) {
        // Nếu thành công, hiển thị thông báo và chuyển hướng về trang chủ
        echo '<script>
                alert("Thanh toán thành công! Cảm ơn bạn đã đặt phòng.");
                window.location.href = "index.html";
              </script>';
    } else {
        // Nếu có lỗi
        echo "Lỗi: " . mysqli_error($con);
    }

    // Đóng kết nối
    mysqli_close($con);
}
?>
