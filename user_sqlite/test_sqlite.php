<?php
// Thay đổi các thông số kết nối dựa trên cấu hình của bạn
$databaseFile = 'database.db';

try {
    // Kết nối tới cơ sở dữ liệu SQLite
    $db = new SQLite3($databaseFile);

    // Truy vấn tên của từng bảng
    $query = "SELECT name FROM sqlite_master WHERE type='table'";
    $result = $db->query($query);

    // Lặp qua các kết quả và in ra tên bảng
    while ($row = $result->fetchArray()) {
        echo "Tên bảng: " . $row['name'] . "<br>";
    }
} catch (Exception $e) {
    echo "Lỗi kết nối đến cơ sở dữ liệu: " . $e->getMessage();
}
?>