<?php
session_start();
include('connection.php');

// Chỉ xử lý khi người dùng đã đăng nhập và đã nhấn gửi
if (!isset($_SESSION['user_id']) || !isset($_POST['submit'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$feedback_text = mysqli_real_escape_string($con, $_POST['feedback_text']);

if(empty($feedback_text)) {
    echo "<script>alert('Vui lòng nhập nội dung phản hồi.'); window.history.back();</script>";
    exit();
}

// Chèn feedback vào CSDL
$sql = "INSERT INTO feedback (user_id, feedback_text) VALUES (?, ?)";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "is", $user_id, $feedback_text);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Cảm ơn bạn đã gửi phản hồi! Chúng tôi sẽ xem xét để cải thiện dịch vụ.'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Đã có lỗi xảy ra. Vui lòng thử lại.'); window.history.back();</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>