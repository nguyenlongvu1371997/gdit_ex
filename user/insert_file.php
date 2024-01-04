<?php

require '../vendor/autoload.php';
use Faker\Factory;

$file_path;
$limit = 0;
if($_GET['file']==1){
    $file_path = 'test.csv';
    $limit = 100000;
} else if($_GET['file']==2){
    $limit = 10000000;
    $file_path = 'user.csv';
} else {
    header("Location: view.php");
    exit;
}

if (!file_exists($file_path)) {
    $noti = "Tệp tin không tồn tại.";
    header("Location: view.php");
    exit;
} 


$start = time();
$faker = Factory::create();
$file = fopen($file_path, 'a');
stream_set_write_buffer($file, 8192);


for($i = 0; $i<$limit; $i++){
    
        $row = [$faker->firstName,$faker->lastName, str_replace("\n", " ",$faker->address), $faker->date('M-d-Y')];
        
        fputcsv($file, $row );
      
}



fclose($file);


// $file = new SplFileObject($file_path, 'a');
// $file->setCsvControl(',', '"', '\\');

// $stream = $file->openFile('a');
// stream_set_write_buffer($stream, 8192);

// for($i = 0; $i<1000000; $i++){
//     $row = [$faker->firstName, $faker->lastName, str_replace("\n", " ",$faker->address), $faker->date('M-d-Y')];
//     $file->fputcsv($row);
//     fwrite($stream, PHP_EOL);
// }

// $file = null;

$end = time();
$time =  $end - $start;
$noti = "thời gian thêm vào file là: ".$time." giây";
header("Location: view.php?noti=$noti");
exit;

?>