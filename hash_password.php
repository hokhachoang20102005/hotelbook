<?php
// Mật khẩu bạn muốn đặt cho admin (ví dụ: 'admin123')
$passwordToHash = 'admin123';

// Mã hóa mật khẩu
$hashedPassword = password_hash($passwordToHash, PASSWORD_BCRYPT);

// In chuỗi đã mã hóa ra màn hình
echo $hashedPassword;
?>