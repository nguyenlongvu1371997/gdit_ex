<?php

$start = time();

$servername = "localhost";
$username = "root";
$password = "cms-8341";
$dbname = "user";

if(!isset($_GET["address"]) || !isset($_GET["sort"])){
           
    header("Location: view.php?noti=$noti");
    exit;
}

// Kết nối tới cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql;

$address = '%'.$conn->real_escape_string($_GET["address"]).'%';
$sort = $conn->real_escape_string($_GET["sort"]);

if($sort==1){
    $sql = "SELECT first_name, last_name, address, birthday 
        FROM users
        WHERE address LIKE ?
        ORDER BY STR_TO_DATE(birthday, '%M-%d-%Y')
        INTO OUTFILE '/htdocs/gdit_ex/user/export.csv'
        FIELDS TERMINATED BY ','
        ENCLOSED BY '\"'
        LINES TERMINATED BY '\n'";
} else if($sort==0) {
    $sql = "SELECT first_name, last_name, address, birthday 
    FROM users
    WHERE address LIKE ?
    ORDER BY STR_TO_DATE(birthday, '%M-%d-%Y') DESC
    INTO OUTFILE '/htdocs/gdit_ex/user/export.csv'
    FIELDS TERMINATED BY ','
    ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'";
} else {
    $noti = "lỗi";
    header("Location: view.php?noti=$noti");
    exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $address);
$stmt->execute();
$stmt->close();
$conn->close();
$end = time();
$time = $end - $start;
$noti = "Dữ liệu đã được export, thời gian: ".$time;
header("Location: view.php?noti=$noti");
exit;


?>
