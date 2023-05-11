<h1>申請紀錄</h1>

<?php

$conn = require_once "config.php";
session_start();

// 查詢 "教室資料表" 的所有內容
$uid = $_SESSION['UID'] ;
$sql = "SELECT * FROM `申請資料表` WHERE 學號 LIKE '$uid' ;";
$result = mysqli_query($conn, $sql);

// 如果查詢結果有資料
if (mysqli_num_rows($result) > 0) {
    // 輸出表格的表頭
    echo "<table border='1'>
            <tr>
                <th>申請表編號</th>
                <th>申請教室編號</th>
                <th>學號</th>
                <th>借用人</th>
                <th>借用日期</th>
                <th>借用時段</th>
                <th>借用設備</th>
                <th>審核情況</th>
                <th>列印</th>
            </tr>";

    // 輸出表格的每一行
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row["申請表編號"] . "</td>
                <td>" . $row["教室編號"] . "</td>
                <td>" . $row["學號"] . "</td>
                <td>" . $row["借用人"] . "</td>
                <td>" . $row["借用日期"] . "</td>
                <td>"; // 借用情況欄位

        // 借用時段
        $id = $row["申請表編號"];
        $book_sql = "SELECT * FROM `借用時段` WHERE `申請表編號`='$id' ";
        $book_result = mysqli_query($conn, $book_sql);
        
        // 借用時段
        $first = true;
        $time = "";
        while($book_row = mysqli_fetch_assoc($book_result)) {
            if($first){
                $time = $time . $book_row["已借用時段"];
                $first = FALSE;
            }
            else{
                $time = $time .",". $book_row["已借用時段"];
            }
        }
        echo $time;

        // 輸出預借資料
        // while($book_row = mysqli_fetch_assoc($book_result)) {
        //     echo $book_row["已借用時段"] . ",";
        // }
        echo "</td><td>";


        // 借用設備
        $id = $row["申請表編號"];
        $equipment = "";
        $equipment_sql = "SELECT * FROM `借用設備`,`申請資料表` WHERE 借用設備.申請表編號 = 申請資料表.申請表編號 AND 申請資料表.申請表編號 = '$id' ";
        $equipment_result = mysqli_query($conn, $equipment_sql);
        $first = true;
        while($equipment_row = mysqli_fetch_assoc($equipment_result)) {
            // 第一項不加","
            if($first) {
                $equipment = $equipment . $equipment_row["借用設備"];
                $first = false;
            } else {
                $equipment = $equipment ."、". $equipment_row["借用設備"];
            }
        }
        echo $equipment;
        echo "</td>";

        // 審核情況
        echo "<td>" . $row["審核情況"] . "</td>";
        
        echo "<td>";
        // 列印按鈕
        echo '<form action="print.php" method="POST">';
        echo '<input type="hidden" name="id" value="' . $id . '">';
        echo '<input type="submit" value="列印">';
        echo '</form>';        

        echo "</td></tr>";
    }
    // 輸出表格的表尾
    echo "</table>";
} 
else {
    echo "<br>"."無申請紀錄!"."<br>";
}
// 上一頁
echo "<a href='welcome.php'>上一頁</a><br>";

// 關閉資料庫連接
mysqli_close($conn);

?>