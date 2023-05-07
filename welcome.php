Welcome.php
成功登入

<?php

$conn = require_once "config.php";

session_start();  //很重要，可以用的變數存在session裡
// var_dump($_SESSION); // 檢查session內的值

$name = $_SESSION["name"];
echo "<h1>你好 ". $_SESSION["name"] . "</h1>";

echo "<a href='logout.php'>登出</a><br>";
echo "<a href='borrow_classroom.php'>查詢教室借用情況</a><br>";
echo "<a href='apply.php'>申請教室借用</a><br>";


// 關閉資料庫連接
mysqli_close($conn);

?>