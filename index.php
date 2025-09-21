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
    <title>Trang Chủ - Khách Sạn Tom2010</title>
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

    <!-- === SLIDER BANNER === -->
    <div class="slider-container">
        <div class="slider-wrapper">
            <!-- Thay thế src bằng 4 ảnh đẹp nhất của bạn -->
            <div class="slide"><img src="images/sl4.png" alt="Banner Image 1"></div>
            <div class="slide"><img src="images/sl2.png" alt="Banner Image 2"></div>
            <div class="slide"><img src="images/sl3.png" alt="Banner Image 3"></div>
            <div class="slide"><img src="images/a1.jpg" alt="Banner Image 4"></div>
        </div>
        <button class="slider-btn prev-btn">&#10094;</button>
        <button class="slider-btn next-btn">&#10095;</button>
        <div class="slider-dots"></div>
    </div>
    <!-- === KẾT THÚC SLIDER === -->

    <div class="main-content">
        <h2 class="section-title">Trải nghiệm không gian nghỉ dưỡng đẳng cấp</h2>
        <div class="room-gallery">
            <div class="room-card">
                <div class="room-image-wrapper">
                    <img src="images/ac_single.jpg" alt="Phòng Đơn">
                </div>
                <div class="room-info">
                    <h3>Phòng Đơn</h3>
                    <p>Giá: 1,000,000 VNĐ / ngày</p>
                    <a href="booking.php?type=Phòng đơn" class="btn-book">Đặt Ngay</a>
                </div>
            </div>
            <div class="room-card">
                <div class="room-image-wrapper">
                    <img src="images/ac_double.jpg" alt="Phòng Đôi">
                </div>
                <div class="room-info">
                    <h3>Phòng Đôi</h3>
                    <p>Giá: 1,500,000 VNĐ / ngày</p>
                    <a href="booking.php?type=Phòng đôi" class="btn-book">Đặt Ngay</a>
                </div>
            </div>
            <div class="room-card">
                <div class="room-image-wrapper">
                    <img src="images/a1.jpg" alt="Phòng Ba">
                </div>
                <div class="room-info">
                    <h3>Phòng Ba</h3>
                    <p>Giá: 2,000,000 VNĐ / ngày</p>
                    <a href="booking.php?type=Phòng ba" class="btn-book">Đặt Ngay</a>
                </div>
            </div>
             <div class="room-card">
                <div class="room-image-wrapper">
                    <img src="images/a2.jpg" alt="Phòng Tổng Thống">
                </div>
                <div class="room-info">
                    <h3>Phòng Tổng Thống</h3>
                    <p>Giá: 5,000,000 VNĐ / ngày</p>
                    <a href="booking.php?type=Phòng tổng thống" class="btn-book">Đặt Ngay</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript cho Slider -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliderWrapper = document.querySelector('.slider-wrapper');
    const slides = document.querySelectorAll('.slide');
    if (!sliderWrapper || slides.length === 0) return; // Thoát nếu không có slider

    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const dotsContainer = document.querySelector('.slider-dots');
    
    let currentIndex = 0;
    const totalSlides = slides.length;
    let autoPlayInterval;

    // Tạo các chấm pagination
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement('span');
        dot.classList.add('dot');
        dot.addEventListener('click', () => {
            goToSlide(i);
        });
        dotsContainer.appendChild(dot);
    }
    const dots = document.querySelectorAll('.dot');

    function updateSlider() {
        sliderWrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    }

    function goToSlide(index) {
        currentIndex = index;
        updateSlider();
        resetAutoPlay();
    }

    function showNextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSlider();
    }

    function showPrevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateSlider();
    }
    
    function startAutoPlay() {
        autoPlayInterval = setInterval(showNextSlide, 4000); // Tự động chuyển slide sau 4 giây
    }

    function resetAutoPlay() {
        clearInterval(autoPlayInterval);
        startAutoPlay();
    }

    nextBtn.addEventListener('click', () => {
        showNextSlide();
        resetAutoPlay();
    });
    
    prevBtn.addEventListener('click', () => {
        showPrevSlide();
        resetAutoPlay();
    });

    // Khởi tạo slider
    updateSlider();
    startAutoPlay();
});
</script>
</body>
</html>

