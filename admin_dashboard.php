<?php
session_start();
include('connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.html');
    exit();
}

// Lấy tất cả booking
$bookings_sql = "SELECT b.id, u.name, u.phone, r.room_number, r.room_type, b.check_in_date, b.check_out_date, b.total_price, b.status 
                 FROM bookings b 
                 JOIN users u ON b.user_id = u.id 
                 JOIN rooms r ON b.room_id = r.id 
                 ORDER BY b.booking_time DESC";
$bookings_result = mysqli_query($con, $bookings_sql);

// Lấy tất cả feedback
$feedback_sql = "SELECT f.feedback_text, f.submission_time, u.name 
                 FROM feedback f 
                 JOIN users u ON f.user_id = u.id 
                 ORDER BY f.submission_time DESC";
$feedback_result = mysqli_query($con, $feedback_sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="admin-container">
    <div class="admin-header">
        <h1>Chào mừng Admin</h1>
        <a href="logout.php">Đăng Xuất</a>
    </div>

    <div class="admin-section">
        <h2>Quản Lý Đặt Phòng</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Khách Hàng</th>
                    <th>Điện Thoại</th>
                    <th>Phòng</th>
                    <th>Loại Phòng</th>
                    <th>Nhận Phòng</th>
                    <th>Trả Phòng</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($bookings_result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['room_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['room_type']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['check_in_date'])); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['check_out_date'])); ?></td>
                    <td><?php echo number_format($row['total_price'], 0, ',', '.'); ?>đ</td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="admin-section">
        <h2>Phản Hồi Từ Khách Hàng</h2>
        <div class="feedback-list">
            <?php while($row = mysqli_fetch_assoc($feedback_result)): ?>
            <div class="feedback-item">
                <p>"<?php echo htmlspecialchars($row['feedback_text']); ?>"</p>
                <span>- <strong><?php echo htmlspecialchars($row['name']); ?></strong> vào lúc <?php echo date('H:i d/m/Y', strtotime($row['submission_time'])); ?></span>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
</body>
</html>