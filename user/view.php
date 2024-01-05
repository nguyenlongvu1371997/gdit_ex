<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
    <style>
        body {
            background-color: black;
        }
        h1, h3, table, span {
            color: white;
        }
    </style>
</head>
<body>
    <h1>TEST</h1>
    <?php
        $noti = $_GET['noti'];
        if(isset($noti)){
            echo "<h3>Thông báo: $noti</h3>";
        } 
    ?>
    <table border="1">
        <tr>
            <th>FILE</th>
            <th>Insert db cách 1</th>
            <th>Insert db cách 2</th>
            <th>Insert db cách 3</th>
            <th>Insert db cách 4</th>
            <th>Thêm record vào file</th>
            <th>Kiểm tra record file</th>
            <th>Xóa record file</th>
        </tr>
        <tr>
            <td>FILE test</td>
            <td><button><a href="insert_case1.php?file=1">Insert 1</a></button></td>
            <td><button><a href="insert_case2.php?file=1">Insert 2</a></button></td>
            <td><button><a href="insert_case3.php?file=1">Insert 3</a></button></td>
            <td><button><a href="insert_case4.php?file=1">Insert 4</a></button></td>
            <td><button><a href="insert_file.php?file=1">Thêm vào file</a></button></td>
            <td><button><a href="check_record.php?file=1">Kiểm tra file</a></button></td>
            <td><button><a href="delete_file.php?file=1">Xóa dữ liệu file</a></button></td>            
        </tr>
        <tr>
            <td>FILE 10 triệu</td>
            <td><button><a href="insert_case1.php?file=2">Insert 1</a></button></td>
            <td><button><a href="insert_case2.php?file=2">Insert 2</a></button></td>
            <td><button><a href="insert_case3.php?file=2">Insert 3</a></button></td>
            <td><button><a href="insert_case4.php?file=2">Insert 4</a></button></td>
            <td><button><a href="">Thêm vào file</a></button></td>
            <td><button><a href="check_record.php?file=2">Kiểm tra file</a></button></td>
            <td><button><a href="">Xóa dữ liệu file</a></button></td>            
        </tr>
    </table>
    <br><br>
    <span>Database: </span>
    <button><a href="check_database.php">Kiểm tra record db</a></button>    
    <button><a href="truncate_database.php">Xóa record db</a></button> <br>
    <br><br>
    <span>File export: </span>
    <button><a href="export_case1.php">Export 1</a></button>
    <button><a href="export_case2.php">Export 2</a></button>
    <button><a href="export_case3.php">Export 3</a></button>
    <button><a href="check_record.php?file=3">Kiểm tra file</a></button>
    <button><a href="delete_file.php?file=3">Xóa dữ liệu file</a></button> <br>

    <br><br>
    <span>Export có sắp xếp theo birthday và tìm theo address</span><br>

    <form action="export_sort1.php" method="GET">
        <input name="address" id="address" type="text">
        <select name="sort" id="sort">
            <option value="1">Tăng theo ngày sinh</option>
            <option value="0">Giảm theo ngày sinh</option>
        </select>
        <button type="submit">Export sắp xếp 1</button>
    </form>
    <br>

    <form action="export_sort2.php" method="GET">
        <input name="address" id="address" type="text">
        <select name="sort" id="sort">
            <option value="1">Tăng theo ngày sinh</option>
            <option value="0">Giảm theo ngày sinh</option>
        
        </select>
        <button type="submit">Export sắp xếp 2</button>
    </form>
    <br>

    <form action="export_sort3.php" method="GET">
        <input name="address" id="address" type="text">
        <select name="sort" id="sort">
            <option value="1">Tăng theo ngày sinh</option>
            <option value="0">Giảm theo ngày sinh</option>
        
        </select>
        <button type="submit">Export sắp xếp 3</button>
    </form>
    <br>

    <form action="export_sort4.php" method="GET">
        <input name="address" id="address" type="text">
        <select name="sort" id="sort">
            <option value="1">Tăng theo ngày sinh</option>
            <option value="0">Giảm theo ngày sinh</option>
        
        </select>
        <button type="submit">Export sắp xếp 4</button>
    </form>
    <br>
    
    
</body>
</html>