<?php
// php用來判斷動作

$host = 'localhost'; // 要連接的 MySQL 資料庫所在的主機
$user = $_POST["user"]; // 登入phpadmin帳號
$passwd = $_POST["password"];// 登入phpadmin密碼
$database = 'test'; // 要連接的 MySQL 資料庫名稱

$connect = new mysqli($host , $user , $passwd , $database); // 使用 mysqli 類別建立一個到 MySQL 資料庫的連線，並將該連線物件儲存在 $connect 變數中

if ($connect->connect_error){
	die("連線資料庫失敗: " . $connect->connect_error);
}
else{
	echo "資料庫連線成功";
}

?>
