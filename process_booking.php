<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || !isset($_POST['submit'])) {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$room_type = $_POST['room_type'];
$check_in_date = $_POST['check_in'];
$check_out_date = $_POST['check_out'];
$price_per_day = $_POST['price_per_day'];

if (strtotime($check_out_date) <= strtotime($check_in_date)) {
    echo "<script>alert('Ngày trả phòng phải sau ngày nhận phòng.'); window.history.back();</script>";
    exit();
}

$sql_rooms = "SELECT id, room_number FROM rooms WHERE room_type = ?";
$stmt_rooms = mysqli_prepare($con, $sql_rooms);
mysqli_stmt_bind_param($stmt_rooms, "s", $room_type);
mysqli_stmt_execute($stmt_rooms);
$result_rooms = mysqli_stmt_get_result($stmt_rooms);

$available_room_id = null;
$assigned_room_number = null;

while ($room = mysqli_fetch_assoc($result_rooms)) {
    $sql_bookings = "SELECT id FROM bookings WHERE room_id = ? AND status != 'cancelled' AND (
                        (? < check_out_date AND ? > check_in_date)
                    )";
    
    $stmt_bookings = mysqli_prepare($con, $sql_bookings);
    mysqli_stmt_bind_param($stmt_bookings, "iss", $room['id'], $check_in_date, $check_out_date);
    mysqli_stmt_execute($stmt_bookings);
    $result_bookings = mysqli_stmt_get_result($stmt_bookings);
    
    if (mysqli_num_rows($result_bookings) == 0) {
        $available_room_id = $room['id'];
        $assigned_room_number = $room['room_number'];
        break;
    }
}

if ($available_room_id !== null) {
    $date1 = new DateTime($check_in_date);
    $date2 = new DateTime($check_out_date);
    $interval = $date1->diff($date2);
    $num_days = $interval->days;
    $total_price = $num_days * $price_per_day;

    $insert_sql = "INSERT INTO bookings (user_id, room_id, check_in_date, check_out_date, total_price) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($con, $insert_sql);
    mysqli_stmt_bind_param($stmt_insert, "iissd", $user_id, $available_room_id, $check_in_date, $check_out_date, $total_price);
    
    if (mysqli_stmt_execute($stmt_insert)) {
        $booking_id = mysqli_insert_id($con);
        $_SESSION['booking_info'] = [
            'booking_id' => $booking_id,
            'total_price' => $total_price,
            'room_number' => $assigned_room_number
        ];
        header("Location: payment.php");
        exit();
    } else {
        echo "<script>alert('Lỗi khi lưu thông tin đặt phòng. Vui lòng thử lại.'); window.location.href='index.php';</script>";
    }

} else {
    echo "<script>alert('Rất tiếc, loại phòng này đã được đặt hết trong khoảng thời gian bạn chọn. Vui lòng chọn ngày khác.'); window.history.back();</script>";
}

mysqli_close($con);
?>