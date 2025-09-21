<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$room_type = isset($_GET['type']) ? $_GET['type'] : '';
if (empty($room_type)) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_sql = "SELECT name, email, phone FROM users WHERE id = ?";
$stmt_user = mysqli_prepare($con, $user_sql);
mysqli_stmt_bind_param($stmt_user, "i", $user_id);
mysqli_stmt_execute($stmt_user);
$user_result = mysqli_stmt_get_result($stmt_user);
$user_data = mysqli_fetch_assoc($user_result);

$price_sql = "SELECT price_per_day FROM rooms WHERE room_type = ? LIMIT 1";
$stmt_price = mysqli_prepare($con, $price_sql);
mysqli_stmt_bind_param($stmt_price, "s", $room_type);
mysqli_stmt_execute($stmt_price);
$price_result = mysqli_stmt_get_result($stmt_price);
$price_data = mysqli_fetch_assoc($price_result);
$price_per_day = $price_data['price_per_day'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác Nhận Đặt Phòng - <?php echo htmlspecialchars($room_type); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="booking-container">
        <div class="booking-form-box">
            <h1>Xác Nhận Đặt Phòng</h1>
            <h2><?php echo htmlspecialchars($room_type); ?></h2>
            <form action="process_booking.php" method="post" id="bookingForm">
                <h3>Thông tin của bạn (đã đăng ký)</h3>
                <div class="user-info">
                    <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($user_data['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
                    <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($user_data['phone']); ?></p>
                </div>

                <h3>Chọn khoảng thời gian</h3>
                <div class="date-picker">
                    <div>
                        <label for="check_in">Ngày nhận phòng:</label>
                        <input type="date" id="check_in" name="check_in" required>
                    </div>
                    <div>
                        <label for="check_out">Ngày trả phòng:</label>
                        <input type="date" id="check_out" name="check_out" required>
                    </div>
                </div>

                <div class="price-summary">
                    <p>Đơn giá: <span id="pricePerDay"><?php echo number_format($price_per_day, 0, ',', '.'); ?></span> VNĐ/ngày</p>
                    <h3>Tổng cộng: <span id="totalPrice">0</span> VNĐ</h3>
                </div>

                <input type="hidden" name="room_type" value="<?php echo htmlspecialchars($room_type); ?>">
                <input type="hidden" name="price_per_day" value="<?php echo $price_per_day; ?>">

                <button type="submit" name="submit">Kiểm Tra & Đặt Phòng</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');
            const totalPriceEl = document.getElementById('totalPrice');
            const pricePerDay = parseFloat(document.getElementById('pricePerDay').textContent.replace(/\./g, ''));
            
            const today = new Date().toISOString().split('T')[0];
            checkInInput.setAttribute('min', today);

            checkInInput.addEventListener('change', function() {
                checkOutInput.setAttribute('min', checkInInput.value);
                calculateTotal();
            });
            checkOutInput.addEventListener('change', calculateTotal);

            function calculateTotal() {
                const checkInDate = new Date(checkInInput.value);
                const checkOutDate = new Date(checkOutInput.value);

                if (checkInInput.value && checkOutInput.value && checkOutDate > checkInDate) {
                    const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
                    const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    const total = dayDiff * pricePerDay;
                    totalPriceEl.textContent = total.toLocaleString('vi-VN');
                } else {
                    totalPriceEl.textContent = '0';
                }
            }
        });
    </script>
</body>
</html>