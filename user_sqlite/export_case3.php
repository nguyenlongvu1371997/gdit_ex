<?php

$start = time();

$servername = "localhost";
$username = "root";
$password = "cms-8341";
$dbname = "user";

// Kết nối tới cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Câu truy vấn SQL để lấy dữ liệu
$sql = "SELECT first_name, last_name, address, birthday
        FROM users
        INTO OUTFILE '/htdocs/gdit_ex/user/export.csv'
        FIELDS TERMINATED BY ','
        ENCLOSED BY '\"'
        LINES TERMINATED BY '\n'";

// Thực thi câu truy vấn
if ($conn->query($sql) === TRUE) {
    $conn->close();
    $end = time();
    $time = $end - $start;
    $noti = "Dữ liệu đã được export, thời gian: ".$time;
    header("Location: view.php?noti=$noti");
    exit;
} else {
    $noti = "Lỗi khi xuất dữ liệu ra file CSV: " . $conn->error;
    $conn->close();
    header("Location: view.php?noti=$noti");
    exit;
}


?>