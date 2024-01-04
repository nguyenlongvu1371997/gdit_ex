<?php

    $noti = '';

    $servername = "localhost";
    $username = "root";
    $password = "cms-8341";
    $dbname = "user";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
         $noti = 'kết nối db false';
         header("Location: view.php?noti=$noti");
         exit;
    }
    
    $sql = "TRUNCATE TABLE users";
    $result = $conn->query($sql);
    if($result){
        $noti = 'Đã xóa dữ liệu trong database';
    } else {
        $noti = 'Xóa bị lỗi';
    }
    $conn->close();

    header("Location: view.php?noti=$noti");
    exit;

?>