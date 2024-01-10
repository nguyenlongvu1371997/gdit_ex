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
        $noti;
    
        $sqlite_file = 'database.db';

        $conn = new SQLite3($sqlite_file);
        

        if (file_exists($file_path)) {
          $file = fopen($file_path, "r");
          if($file){
            while(($row = fgetcsv($file)) !== FALSE) {
              $first_name = $conn->escapeString($row[0]);
              $last_name = $conn->escapeString($row[1]);
              $address = $conn->escapeString($row[2]);
              $birthday = $conn->escapeString($row[3]);
              $sql = "INSERT INTO users (first_name, last_name, address, birthday) VALUES ('$first_name', '$last_name', '$address', '$birthday')";
              if(!$conn->exec($sql)){
                  var_dump($row);
                  echo "<br>";
              }
                
            }


          } else {
            $noti = "không thể mở file";
            header("Location: view.php?noti=$noti");
            exit;
          }
        } else {
          $noti = "file ko tồn tại";
          header("Location: view.php?noti=$noti");
          exit;
        }
        
       

        $conn->close();
    
        $end = time();

        $time =  $end - $start;
        $noti = "thời gian thêm vào db là: ".$time." giây";
        header("Location: view.php?noti=$noti");
        exit;

?>