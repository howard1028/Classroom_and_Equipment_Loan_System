借教室

<?php

$conn = require_once "config.php";

// 查詢 "教室資料表" 的所有內容
$result = mysqli_query($conn, "SELECT * FROM `教室資料表`");

// 如果查詢結果有資料
if (mysqli_num_rows($result) > 0) {
    // 輸出表格的表頭
    echo "<table border='1'>
            <tr>
                <th>教室編號</th>
                <th>教室名稱</th>
                <th>教室位置</th>
                <th>可容納人數</th>
                <th>借用時段</th>
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
                echo $book_row["已借用日期"] . " 第" . $book_row["已借用時段"] . "節"."<br>";
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
// 上一頁
echo "<a href='welcome.php'>上一頁</a><br>";

// 關閉資料庫連接
mysqli_close($conn);

?>