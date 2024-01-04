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

    $sql = "SELECT count(*) as count from users";
    $result = $conn->query($sql);
    $noti = "Số lượng record trong database là: ". $result->fetch_assoc()["count"];
    $conn->close();

    header("Location: view.php?noti=$noti");
    exit;

?>