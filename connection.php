<?php
$servername = "localhost:3307"; // QUAN TRỌNG: Thêm cổng 3307 mà chúng ta đã đổi
$username = "root";
$password = "";
$dbname = "hotel";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($con, 'utf8mb4');
?>