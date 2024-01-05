<?php

$file_path;

if($_GET['file']==1){
    $file_path = 'test.csv';
} else if($_GET['file']==2){
    $file_path = 'user.csv';
} else {
    header("Location: view.php");
    exit;
} 

$start = time();

$servername = "localhost";
$username = "root";
$password = "cms-8341";
$dbname = "user";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "LOAD DATA INFILE '/htdocs/gdit_ex/user/$file_path'
        INTO TABLE users
        FIELDS TERMINATED BY ','
        ENCLOSED BY '\"'
        LINES TERMINATED BY '\n'
        (first_name, last_name, address, birthday)";

if ($conn->query($sql) === TRUE) {
    $conn->close();
    $end = time();
    $time =  $end - $start;
    $noti = "thời gian thêm vào db là: ".$time." giây";
    header("Location: view.php?noti=$noti");
    exit;
} else {
    $conn->close();
    $noti = "thời gian thêm vào db là: ".$time." giây";
    header("Location: view.php?noti=$noti");
    exit;
}


?>