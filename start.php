<?php
// 處理start
// 初始化Session
session_start();

// 檢查使用者是否已經登入
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	header("location: welcome.php");
    exit;  //跳一次停
}
else{ 
    header("location: index.html");
    exit;  //跳一次停
}

?>

