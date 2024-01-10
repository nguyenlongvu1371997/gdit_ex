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
    
      $sql = "INSERT INTO users (first_name, last_name, address, birthday) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      


      if (file_exists($file_path)) {
        $file = fopen($file_path, "r");
        if($file){
          // $conn->exec('BEGIN');
          while(($row = fgetcsv($file)) !== FALSE) {
            $first_name = $row[0];
            $last_name = $row[1];
            $address = $row[2];
            $birthday = $row[3];

            $stmt->bindValue(1, $first_name, SQLITE3_TEXT);
            $stmt->bindValue(2, $last_name, SQLITE3_TEXT);
            $stmt->bindValue(3, $address, SQLITE3_TEXT);
            $stmt->bindValue(4, $birthday, SQLITE3_TEXT);
            
            $stmt->execute();
           
              
          }

          // $conn->exec('COMMIT');

        } else {
          echo "Ko thể mở file";
        }
      } else {
        echo "file ko tồn tại";
      }
  
    
    
    $stmt->close();
    $conn->close();
    
    $end = time();

    $time =  $end - $start;
    $noti = "thời gian thêm vào db là: ".$time." giây";
    header("Location: view.php?noti=$noti");
    exit;


?>