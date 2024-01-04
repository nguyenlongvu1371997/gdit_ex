<?php

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
        WHERE address LIKE '%$address%'
        ORDER BY STR_TO_DATE(birthday, '%M-%d-%Y')
        INTO OUTFILE '/path/to/export.csv'
        FIELDS TERMINATED BY ','
        ENCLOSED BY '\"'
        LINES TERMINATED BY '\n'";

// Thực thi câu truy vấn
if ($conn->query($sql) === TRUE) {
    $noti = "Dữ liệu đã được xuất ra file CSV thành công.";
    header("Location: view.php?noti=$noti");
    exit;
} else {
    $noti = "Lỗi khi xuất dữ liệu ra file CSV: " . $conn->error;
    header("Location: view.php?noti=$noti");
    exit;
}

$conn->close();

?>