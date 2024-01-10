<?php

    $noti = '';
    $sqlite_file = 'database.db';
    $conn = new SQLite3($sqlite_file);

    
    $sql = "DELETE FROM users";
    $result = $conn->exec($sql);
    if($result){
        $sql = "DELETE FROM sqlite_sequence WHERE name='users'";
        $conn->exec($sql);

        // VACUUM để giải phóng không gian và đặt lại ID tự tăng
        $sql = "VACUUM";
        $conn->exec($sql);
        $noti = 'Đã xóa dữ liệu trong database';
    } else {
        $noti = 'Xóa bị lỗi';
    }
    $conn->close();

    header("Location: view.php?noti=$noti");
    exit;

?>