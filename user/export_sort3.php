<?php
    
    $start = time();
    $noti = '';

    $servername = "localhost";
    $username = "root";
    $password = "cms-8341";
    $dbname = "user";

    
    if(!isset($_GET["address"]) || !isset($_GET["sort"])){
           
            header("Location: view.php?noti=$noti");
            exit;
        }
    

    
    
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            $noti = 'kết nối db false';
            header("Location: view.php?noti=$noti");
            exit;
    }

    $address = $conn->real_escape_string($_GET["address"]);
    $sort = $conn->real_escape_string($_GET["sort"]);


    $conn->begin_transaction();
   
    $sql;

    if($sort==1){
        $sql = "SELECT STR_TO_DATE(birthday, '%M-%d-%Y') as format_birthday, first_name, last_name, address, birthday
        FROM users
        WHERE address like '%$address%'
        ORDER BY format_birthday 
        LIMIT ? 
        OFFSET ?";
    } else if($sort==0) {
        $sql = "SELECT STR_TO_DATE(birthday, '%M-%d-%Y') as format_birthday, first_name, last_name, address, birthday
        FROM users
        WHERE address like '%$address%'
        ORDER BY format_birthday DESC
        LIMIT ? 
        OFFSET ?";
    } else {
        $noti = "lỗi";
        header("Location: view.php?noti=$noti");
        exit;
    }


    $off_set = 0;
    $limit = 100000;
    
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
    
    $conn->commit();
    $conn->close();
    $end = time();
    $time = $end - $start;
    $noti = "Thời gian tải lên là: ".$time;
    header("Location: view.php?noti=$noti");
    exit;
?>