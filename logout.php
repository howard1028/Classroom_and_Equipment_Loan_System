<?php 
// 處理登出
session_start(); 
$_SESSION = array(); // 清除session所有變數
session_destroy(); // 銷毀session
header('location:index.html'); 

?>