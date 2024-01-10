<?php
    $file_path;

    if($_GET['file']==1){
        $file_path = '../user/test.csv';
    } else if($_GET['file']==2){
        $file_path = '../user/user.csv';
    } else {
        header("Location: view.php");
        exit;
    } 
    $start = time();

    $sqlite_file = 'database.db';

    $conn = new SQLite3($sqlite_file);

   
    if (!$conn) {
        die("Connection failed: " . $conn);
      }
    
      $sql = "INSERT INTO users (first_name, last_name, address, birthday) VALUES ";
    
      


      if (file_exists($file_path)) {
        $file = fopen($file_path, "r");
        if($file){
            $count = 0;
            $value = [];
            $size = 500000;
            $conn->exec('BEGIN');
            while(($row = fgetcsv($file)) !== FALSE){
                $count++;
                $first_name = $conn->escapeString($row[0]);
                $last_name = $conn->escapeString($row[1]);
                $address = $conn->escapeString($row[2]);
                $date = $conn->escapeString($row[3]);
                $value[] = "('" . $first_name . "','" . $last_name . "','" . $address . "','" . $date . "')";
                if($count % $size === 0){
                    $sql .= implode(",", $value);
                    $conn->exec($sql);
                    $value = [];
                    $sql = "INSERT INTO users (first_name, last_name, address, birthday) VALUES ";
                }
                
            }

            $sql .= implode(",", $value);
            $conn->exec($sql);
            $value = [];
            $conn->exec('COMMIT');

        } else {
          echo "Ko thể mở file";
        }
      } else {
        echo "file ko tồn tại";
      }
  
    
    
   
    $conn->close();
    
    $end = time();

    $time =  $end - $start;
    $noti = "thời gian thêm vào db là: ".$time." giây";
    header("Location: view.php?noti=$noti");
    exit;


?>