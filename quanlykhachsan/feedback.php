<?php
// Bao gồm tệp kết nối
include("connection.php");

// Kiểm tra xem form đã được gửi đi chưa
if(isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $feedback = mysqli_real_escape_string($con, $_POST['feedback']);

    // Tạo câu lệnh SQL
    $sql = "INSERT INTO feedback (name, email, feedback_text) VALUES ('$name', '$email', '$feedback')";

    // Đổi mysql_query thành mysqli_query
    $result = mysqli_query($con, $sql);

    if($result) {
        // Nếu thành công, hiển thị thông báo
        echo '<script>
                alert("Cảm ơn bạn đã gửi phản hồi!");
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
