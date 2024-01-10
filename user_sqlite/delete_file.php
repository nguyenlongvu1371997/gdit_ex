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

$file = fopen($file_path, 'w');
fclose($file);
$noti = 'đã xóa';
header("Location: view.php?noti=$noti");
exit;

?>