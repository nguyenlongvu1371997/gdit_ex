<?php

    $start = time();
    $noti = '';

    

    
    if(!isset($_GET["address"]) || !isset($_GET["sort"])){
            $noti = "lỗi";
            header("Location: view.php?noti=$noti");
            exit;
        }
    

    $sqlite_file = 'database.db';

    $conn = new SQLite3($sqlite_file);
    
    // Check connection
    if (!$conn) {
            die("Connection failed:");
            $noti = 'kết nối db false';
            header("Location: view.php?noti=$noti");
            exit;
    }

    $address = "%".$conn->escapeString($_GET["address"])."%";
    $sort = $_GET["sort"];

    $table = uniqid('user_');

    $conn->exec('BEGIN');
   
    if(!$conn->exec("CREATE TABLE $table(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        first_name VARCHAR(255),
        last_name VARCHAR(255),
        address TEXT,
        birthday VARCHAR(255)
    )")){
        $noti = "lỗi";
        header("Location: view.php?noti=$noti");
        exit;
    }

    $sql;

    if($sort==1){

        $sql = "INSERT INTO $table (birthday, first_name, last_name, address)
        SELECT birthday, first_name, last_name, address
        FROM users 
        WHERE address like ?
        ORDER BY date(strftime('%Y-%m-%d', substr(birthday, 8, 4) || '-' || 
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
         substr(birthday, 5, 2)))";

    } else if($sort==0) {
        $sql = "INSERT INTO $table (birthday, first_name, last_name, address)
        SELECT birthday, first_name, last_name, address
        FROM users 
        WHERE address like ?
        ORDER BY date(strftime('%Y-%m-%d', substr(birthday, 8, 4) || '-' || 
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
         substr(birthday, 5, 2))) DESC";
    } else {
        $noti = "lỗi";
        header("Location: view.php?noti=$noti");
        exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $address, SQLITE3_TEXT);
    $stmt->execute();

    $id = 0;
    $limit = 100000;
    $sql = "SELECT first_name , last_name, address, birthday from $table WHERE id > ? limit ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(2, $limit, SQLITE3_INTEGER);


    $file_path = '../user/export.csv';
    if (!file_exists($file_path)) {
        $noti = "Tệp tin không tồn tại.";
        header("Location: view.php?noti=$noti");
        exit;
    } 
    
    
    
    $file = fopen($file_path, 'a');
    stream_set_write_buffer($file, 8192);
    
    while(TRUE){
        
        $stmt->bindValue(1, $id, SQLITE3_INTEGER);
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

        $id += $limit;

    }
    
    
    fclose($file);
    $conn->query("DROP TABLE $table");
    $conn->exec('COMMIT');
    $conn->close();
    $end = time();
    $time = $end - $start;
    $noti = "Thời gian tải lên là: ".$time;
    header("Location: view.php?noti=$noti");
    exit;
?>