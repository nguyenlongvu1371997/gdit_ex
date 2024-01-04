<?php

    $start = time();
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

    $off_set = 0;
    $limit = 100000;
    $sql = "SELECT first_name , last_name, address, birthday from users LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $limit, $off_set);

    $result = $conn->query($sql);
    
    

    $file_path = 'export.csv';
    if (!file_exists($file_path)) {
        $noti = "Tệp tin không tồn tại.";
        header("Location: view.php?noti=$noti");
        exit;
    } 
    
    
    
    $file = fopen($file_path, 'a');
    stream_set_write_buffer($file, 8192);
    
    while(TRUE){
        $stmt->execute();
        $result = $stmt->get_result();
    
        while($row = $result->fetch_assoc()){
            $row_csv = [$row['first_name'], $row['last_name'], $row['address'], $row['birthday']];
            fputcsv($file, $row_csv);
        
        }

        if($result->num_rows<$limit){
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