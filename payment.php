<?php
session_start();
include('connection.php');

// Bảo vệ trang, kiểm tra người dùng đã đăng nhập và có thông tin đặt phòng chưa
if (!isset($_SESSION['user_id']) || !isset($_SESSION['booking_info'])) {
    header('Location: index.php');
    exit();
}

// Lấy thông tin từ session
$booking_info = $_SESSION['booking_info'];
$total_price = $booking_info['total_price'];
$room_number = $booking_info['room_number'];

// Lấy số điện thoại của người dùng để tạo cú pháp chuyển khoản
$user_id = $_SESSION['user_id'];
$user_sql = "SELECT phone FROM users WHERE id = ?";
$stmt = mysqli_prepare($con, $user_sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
$user_phone = $user['phone'];

// Tạo nội dung chuyển khoản
$transfer_syntax = $user_phone . '+' . $room_number;

// Sau khi hiển thị, có thể xóa thông tin booking khỏi session để tránh đặt lại nhầm
unset($_SESSION['booking_info']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán Đặt Phòng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="payment-container">
    <div class="payment-box">
        <h1>Thanh Toán</h1>
        <p class="success-message">Đặt phòng thành công! Vui lòng thanh toán để hoàn tất.</p>

        <div class="payment-details">
            <p><strong>Số phòng của bạn:</strong> <?php echo htmlspecialchars($room_number); ?></p>
            <p><strong>Tổng số tiền cần thanh toán:</strong></p>
            <h2 class="total-price"><?php echo number_format($total_price, 0, ',', '.'); ?> VNĐ</h2>
        </div>

        <div class="qr-code-section">
            <h3>Quét mã QR để thanh toán</h3>
            <p>Sử dụng ứng dụng ngân hàng hoặc ví điện tử của bạn.</p>
            <img src="images/qr_code_placeholder.png" alt="Mã QR Thanh toán" class="qr-code-img">
            </div>

        <div class="transfer-info">
            <h4>Nội dung chuyển khoản</h4>
            <p>Vui lòng ghi đúng nội dung dưới đây để chúng tôi xác nhận nhanh chóng:</p>
            <div class="transfer-syntax-box">
                <span id="transferSyntax"><?php echo htmlspecialchars($transfer_syntax); ?></span>
                <button onclick="copySyntax()">Sao chép</button>
            </div>
        </div>
        
        <a href="index.php" class="back-to-home">Quay về Trang chủ</a>
        <p class="note">Sau khi thanh toán, chúng tôi sẽ xác nhận đặt phòng của bạn qua email hoặc điện thoại.</p>
    </div>
</div>

<script>
    function copySyntax() {
        const syntax = document.getElementById('transferSyntax').innerText;
        navigator.clipboard.writeText(syntax).then(function() {
            alert('Đã sao chép nội dung chuyển khoản!');
        }, function(err) {
            alert('Lỗi khi sao chép: ', err);
        });
    }
</script>
</body>
</html>