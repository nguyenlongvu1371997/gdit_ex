<?php
    
    $start = time();
    $noti = '';

    

    
    if(!isset($_GET["address"]) || !isset($_GET["sort"])){
           
            header("Location: view.php?noti=$noti");
            exit;
        }
    

    $sqlite_file = 'database.db';

    $conn = new SQLite3($sqlite_file);
    
    // Check connection
    if (!$conn) {
            die("Connection failed: ");
            $noti = 'kết nối db false';
            header("Location: view.php?noti=$noti");
            exit;
    }

    $address = "%".$conn->escapeString($_GET["address"])."%";
    $sort = $_GET["sort"];


    
   
    $sql;

    if($sort==1){
        $sql = "SELECT first_name, last_name, address, birthday,
        date(strftime('%Y-%m-%d', substr(birthday, 8, 4) || '-' || 
        CASE substr(birthday, 1, 3)
            WHEN 'Jan' THEN '01'
            WHEN 'Feb' THEN '02'
            WHEN 'Mar' THEN '03'
            WHEN 'Apr' THEN '04'
            WHEN 'May' THEN '05'
            WHEN 'Jun' THEN '06'
            WHEN 'Jul' THEN '07'
            WHEN 'Aug' THEN '08'
            WHEN 'Sep' THEN '09'
            WHEN 'Oct' THEN '10'
            WHEN 'Nov' THEN '11'
            WHEN 'Dec' THEN '12'
        END || '-' || 
        substr(birthday, 5, 2))) AS formatted_birthday
        FROM users
        WHERE address LIKE ?
        ORDER BY formatted_birthday
        LIMIT ?
        OFFSET ?";
    } else if($sort==0) {
        $sql = "SELECT first_name, last_name, address, birthday,
        date(strftime('%Y-%m-%d', substr(birthday, 8, 4) || '-' || 
        CASE substr(birthday, 1, 3)
            WHEN 'Jan' THEN '01'
            WHEN 'Feb' THEN '02'
            WHEN 'Mar' THEN '03'
            WHEN 'Apr' THEN '04'
            WHEN 'May' THEN '05'
            WHEN 'Jun' THEN '06'
            WHEN 'Jul' THEN '07'
            WHEN 'Aug' THEN '08'
            WHEN 'Sep' THEN '09'
            WHEN 'Oct' THEN '10'
            WHEN 'Nov' THEN '11'
            WHEN 'Dec' THEN '12'
        END || '-' || 
        substr(birthday, 5, 2))) AS formatted_birthday
        FROM users
        WHERE address LIKE ?
        ORDER BY formatted_birthday DESC
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
    
    if (!$stmt) {
        $noti = $conn->lastErrorMsg();
        header("Location: view.php?noti=$noti");

        die();
    }

    $file_path = '../user/export.csv';
    if (!file_exists($file_path)) {
        $noti = "Tệp tin không tồn tại.";
        header("Location: view.php?noti=$noti");
        exit;
    } 
    
    
    
    $file = fopen($file_path, 'a');
    stream_set_write_buffer($file, 8192);
    
    while(TRUE){
        $stmt->bindValue(1, $address, SQLITE3_TEXT);
        $stmt->bindValue(2, $limit, SQLITE3_INTEGER);
        $stmt->bindValue(3, $off_set, SQLITE3_INTEGER);
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