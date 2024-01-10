<?php
$sqlite_file = 'database.db';

$connection = new SQLite3($sqlite_file);
if(!$connection) {
    die("Kết nối tới cơ sở dữ liệu thất bại.");
}

echo "oke";
echo "<br>";

// $sql = 'INSERT INTO my_table(name)
// VALUES ("abc1"), ("abc2");
// ';

// if ($connection->exec($sql) !== false) {
//     echo "Tạo cơ sở dữ liệu thành công.";
// } else {
//     echo "Có lỗi xảy ra khi tạo cơ sở dữ liệu.";
// }


$sql = 'SELECT * FROM my_table';

$result = $connection->query($sql);
while ($row = $result->fetchArray()) {
    // Xử lý dữ liệu từ mỗi hàng
    $id = $row['id'];
    $name = $row['name'];
    echo "id: ".$id."  name: ".$name . "<br>";
}

$connection->close();

?>