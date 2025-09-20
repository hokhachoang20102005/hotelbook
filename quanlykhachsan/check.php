<?php
// Bao gồm tệp kết nối
include("connection.php");

// Logic của tệp này không hoàn toàn rõ ràng từ bản gốc,
// nhưng đây là một phiên bản đã được nâng cấp lên mysqli.
// Giả sử nó dùng để kiểm tra một điều gì đó và trả về kết quả.

// Ví dụ: Kiểm tra xem có phòng nào được đặt trong một ngày cụ thể không
if(isset($_GET['date'])) {
    $date = mysqli_real_escape_string($con, $_GET['date']);
    
    $sql = "SELECT * FROM customer WHERE check_in = '$date'";
    
    // Đổi mysql_query thành mysqli_query
    $result = mysqli_query($con, $sql);
    
    if($result) {
        // Đổi mysql_num_rows thành mysqli_num_rows
        $count = mysqli_num_rows($result);
        echo "Tìm thấy " . $count . " phòng được đặt vào ngày " . $date;
    } else {
        echo "Lỗi truy vấn: " . mysqli_error($con);
    }
} else {
    echo "Vui lòng cung cấp ngày để kiểm tra.";
}

// Đóng kết nối
mysqli_close($con);
?>
