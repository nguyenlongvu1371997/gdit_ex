<?php

$noti = '';
$sqlite_file = 'database.db';
$conn = new SQLite3($sqlite_file);


$sql = "SELECT COUNT(id) as count FROM users";
$result = $conn->query($sql);
$row = $result->fetchArray();
$noti = "database có: ".$row["count"]." record";
$conn->close();

header("Location: view.php?noti=$noti");
exit;


?>