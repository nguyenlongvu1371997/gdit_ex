<?php
    $file_path;

    if($_GET['file']==1){
        $file_path = 'test.csv';
    } else if($_GET['file']==2){
        $file_path = 'user.csv';
    } else {
        header("Location: view.php");
        exit;
    } 
    $start = time();

    $servername = "localhost";
    $username = "root";
    $password = "cms-8341";
    $dbname = "user";
  
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
    
      $sql = "INSERT INTO users (first_name, last_name, address, birthday) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('ssss', $first_name, $last_name, $address, $date);


      if (file_exists($file_path)) {
        $file = fopen($file_path, "r");
        if($file){
          $conn->begin_transaction();
          while(($row = fgetcsv($file)) !== FALSE) {
            $first_name = $conn->real_escape_string($row[0]);
            $last_name = $conn->real_escape_string($row[1]);
            $address = $conn->real_escape_string($row[2]);
            $date = $conn->real_escape_string($row[3]);
            
            $stmt->execute();
           
              
          }

          $conn->commit();

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