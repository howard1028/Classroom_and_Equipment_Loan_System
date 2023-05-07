Welcome.php
成功登入

<?php

$conn = require_once "config.php";

session_start();  //很重要，可以用的變數存在session裡
// var_dump($_SESSION); // 檢查session內的值

$name = $_SESSION["name"];
echo "<h1>你好 ". $_SESSION["name"] . "</h1>";
echo "<a href='logout.php'>登出</a>";


// 檢查連接是否成功
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 查詢 "教室資料表" 的所有內容
$sql = "SELECT * FROM `教室資料表`";
$result = mysqli_query($conn, $sql);

// 如果查詢結果有資料
if (mysqli_num_rows($result) > 0) {
    // 輸出表格的表頭
    echo "<table>
            <tr>
                <th>教室編號</th>
                <th>教室名稱</th>
                <th>教室位置</th>
                <th>可容納人數</th>
                <th>借用情況</th>
            </tr>";

    // 輸出表格的每一行
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row["教室編號"] . "</td>
                <td>" . $row["教室名稱"] . "</td>
                <td>" . $row["教室位置"] . "</td>
                <td>" . $row["可容納人數"] . "</td>
                <td>"; // 借用情況欄位

        // 查詢教室的預借情況
        $classroom_id = $row["教室編號"];
        $book_sql = "SELECT * FROM `借用時段` WHERE `教室編號`='$classroom_id'";
        $book_result = mysqli_query($conn, $book_sql);

        // 如果該教室有預借資料
        if (mysqli_num_rows($book_result) > 0) {
            // 輸出預借資料
            while($book_row = mysqli_fetch_assoc($book_result)) {
                echo $book_row["已借用日期"] . " " . $book_row["已借用時段"] . "<br>";
            }
        } 
        else {
            echo "無借用資料";
        }
        echo "</td></tr>";
    }
    // 輸出表格的表尾
    echo "</table>";
} 
else {
    echo "無資料!";
}

// 關閉資料庫連接
mysqli_close($conn);

?>