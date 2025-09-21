<?php
session_start();
include('connection.php');

$is_logged_in = isset($_SESSION['user_id']);
if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT name FROM users WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    $user_name = $user['name'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tổng Quan - Khách Sạn Tom2010</title>
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
                <li><a href="overview.php">Tổng Quan</a></li>
                <?php if ($is_logged_in): ?>
                    <li><a href="my_bookings.php">Lịch Sử Đặt Phòng</a></li>
                    <li class="user-menu">
                        <span>Chào, <?php echo htmlspecialchars($user_name); ?></span>
                        <a href="logout.php" class="logout-btn">Đăng Xuất</a>
                    </li>
                <?php else: ?>
                    <li><a href="login.html" class="logout-btn" style="background-color: #007bff;">Đăng Nhập</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <div class="main-content">
        <div class="overview-top-grid">
            <div class="content-column">
                <div class="overview-section">
                    <h2>Thư Viện Ảnh</h2>
                    <div class="gallery-grid">
                    <img src="images/a1.jpg" alt="Ảnh khách sạn 1">
                    <img src="images/a2.jpg" alt="Ảnh khách sạn 2">
                    <img src="images/a3.jpg" alt="Ảnh khách sạn 3">
                    <img src="images/a4.jpg" alt="Ảnh khách sạn 4">
                    <img src="images/a5.jpg" alt="Ảnh khách sạn 5">
                    <img src="images/a6.jpg" alt="Ảnh khách sạn 6">
                    <img src="images/a7.jpg" alt="Ảnh khách sạn 7">
                    <img src="images/a8.jpg" alt="Ảnh khách sạn 8">
                    <img src="images/a9.jpg" alt="Ảnh khách sạn 9">
                    <img src="images/a10.jpg" alt="Ảnh khách sạn 10">
                    <img src="images/a11.jpg" alt="Ảnh khách sạn 11">
                    <img src="images/a12.jpg" alt="Ảnh khách sạn 12">
                    </div>
                </div>

                <?php if ($is_logged_in): ?>
                <div class="overview-section" id="feedback-wrapper-overview">
                     <div id="feedback-section">
                        <h2>Chúng tôi luôn lắng nghe bạn</h2>
                        <form action="process_feedback.php" method="post">
                            <textarea name="feedback_text" placeholder="Nhập phản hồi của bạn..." required></textarea>
                            <button type="submit" name="submit">Gửi</button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="sidebar-column">
                <div class="overview-section">
                    <h2>Liên Hệ Với Chúng Tôi</h2>
                    <div class="contact-grid">
                        <div class="contact-person">
                            <h4>Hồ Khắc Hoàng</h4>
                            <p>0972862834</p>
                        </div>
                        <div class="contact-person">
                            <h4>Tom2010</h4>
                            <p>20/10/2005</p>
                        </div>
                        <div class="contact-person">
                            <h4>Lớp Th28.17</h4>
                            <p>MSV: 2823240989</p>
                        </div>
                        <div class="contact-person">
                            <h4>Trường Đại học</h4>
                            <p>Kinh Doanh và Công Nghệ Hà Nội</p>
                        </div>
                    </div>
                    <div class="social-links">
                        <a href="https://www.facebook.com/tomm201025/" target="_blank"><img src="images/fb.png" alt="Facebook"></a>
                        <a href="https://accounts.google.com/" target="_blank"><img src="images/gg.png" alt="Google"></a>
                        <a href="https://twitter.com/login" target="_blank"><img src="images/tele.png" alt="Twitter"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="introduction-wrapper">
            <div class="overview-section hotel-introduction">
                <h2>Khách Sạn Khắc Hoàng Star - Thiên Đường Nghỉ Dưỡng</h2>
                <p>Tọa lạc tại trái tim của bãi biển Thiên Cầm, Hà Tĩnh, Khách sạn Khắc Hoàng Star là biểu tượng của sự sang trọng và yên bình. Với kiến trúc độc đáo hòa mình vào thiên nhiên, chúng tôi mang đến một không gian nghỉ dưỡng lý tưởng, nơi bạn có thể lắng nghe tiếng sóng vỗ và cảm nhận làn gió biển trong lành.</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>