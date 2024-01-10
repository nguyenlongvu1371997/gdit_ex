<?php

$file_path;
if($_GET['file']==1){
    $file_path = '../user/test.csv';
} else if($_GET['file']==2){
    $file_path = '../user/user.csv';
} else if($_GET['file']==3){
    $file_path = '../user/export.csv';
} else {
    header("Location: view.php");
    exit;
}
$row_count = 0;
$noti = '';
if (file_exists($file_path)) {
    $file = fopen($file_path, 'r');
    
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $row_count++;
        }
        
        fclose($file);
    } else {
        $noti = "false";
    }   
        $noti = "Số lượng bản ghi trong tệp tin CSV là: " . $row_count;
} else {
    $noti = "Tệp tin không tồn tại.";
}


// $file = fopen($file_path, 'w');
// fclose($file);
header("Location: view.php?noti=$noti");
exit;

?>