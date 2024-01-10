<?php

    $start = time();
    $noti = '';

    $sqlite_file = 'database.db';

    $conn = new SQLite3($sqlite_file);
    
    // Check connection
    if (!$conn) {
        die("Connection failed: ");
        $noti = 'kết nối db false';
        header("Location: view.php?noti=$noti");
        exit;
    }

    $off_set = 0;
    $limit = 100000;
    $sql = "SELECT first_name , last_name, address, birthday from users LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    


    $file_path = '../user/export.csv';
    if (!file_exists($file_path)) {
        $noti = "Tệp tin không tồn tại.";
        header("Location: view.php?noti=$noti");
        exit;
    } 
    
    
    
    $file = fopen($file_path, 'a');
    stream_set_write_buffer($file, 8192);
    
    while(TRUE){
        $stmt->bindValue(1, $limit, SQLITE3_INTEGER);
        $stmt->bindValue(2, $off_set, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $count = 0;
        
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            $count++;
            $row_csv = [$row['first_name'], $row['last_name'], $row['address'], $row['birthday']];
            fputcsv($file, $row_csv);
        }

        if($count<$limit){
            break;
        } 

        $off_set += $limit;

    }
    
    
    fclose($file);
    $conn->close();
    $end = time();
    $time = $end - $start;
    $noti = "Thời gian tải lên là: ".$time;
    header("Location: view.php?noti=$noti");
    exit;
?>