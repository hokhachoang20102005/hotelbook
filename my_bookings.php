<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin user và lịch sử đặt phòng của họ
$user_sql = "SELECT name FROM users WHERE id = $user_id";
$user_result = mysqli_query($con, $user_sql);
$user_data = mysqli_fetch_assoc($user_result);
$user_name = $user_data['name'];

$bookings_sql = "SELECT 
                    b.check_in_date, 
                    b.check_out_date, 
                    b.total_price, 
                    b.status,
                    r.room_type,
                    r.room_number
                FROM bookings b
                JOIN rooms r ON b.room_id = r.id
                WHERE b.user_id = ?
                ORDER BY b.booking_time DESC";

$stmt = mysqli_prepare($con, $bookings_sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$bookings_result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sử Đặt Phòng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="holder">
    <div id="header">
        <div class="logo">
            <a href="index.php"><img src="images/22.jpg" alt="Hotel Logo"/></a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Trang Chủ</a></li>
                <li><a href="overview.php">Giới Thiệu</a></li>
                <li><a href="my_bookings.php">Lịch Sử Đặt Phòng</a></li>
                <li class="user-menu">
                    <span>Chào, <?php echo htmlspecialchars($user_name); ?></span>
                    <a href="logout.php" class="logout-btn">Đăng Xuất</a>
                </li>
            </ul>
        </nav>
    </div>
    
    <div class="my-bookings-container">
        <h1>Lịch Sử Đặt Phòng Của Bạn</h1>
        <?php if (mysqli_num_rows($bookings_result) > 0): ?>
            <table class="bookings-table">
                <thead>
                    <tr>
                        <th>Số Phòng</th>
                        <th>Loại Phòng</th>
                        <th>Ngày Nhận Phòng</th>
                        <th>Ngày Trả Phòng</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($booking = mysqli_fetch_assoc($bookings_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['room_number']); ?></td>
                            <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($booking['check_in_date'])); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($booking['check_out_date'])); ?></td>
                            <td><?php echo number_format($booking['total_price'], 0, ',', '.'); ?> VNĐ</td>
                            <td><span class="status-<?php echo htmlspecialchars($booking['status']); ?>"><?php echo htmlspecialchars($booking['status']); ?></span></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-bookings">Bạn chưa có lần đặt phòng nào.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>