<?php
// 處理登入(index.html)

// 引入資料庫連線
$conn = require_once "config.php";
 
// 接收從表單傳送過來的帳號和密碼
$UID = $_POST["UID"];
$password = $_POST["password"];

// 將密碼進行雜湊
$password_hash = password_hash($password,PASSWORD_DEFAULT);

// 當使用者提交了表單（HTTP方法為POST）時，將會觸發以下事件
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "SELECT * FROM 使用者資料表 WHERE 學號 = '$UID' ";
    $result = mysqli_query($conn,$sql);

    // 查詢返回一行，而且該行的密碼欄位和輸入的密碼一致
    if(mysqli_num_rows($result)==1 && $password==mysqli_fetch_assoc($result)["password"]){
        // 建立一個新的session，將使用者的ID和帳號名稱存儲在session變數中
        session_start();
        $_SESSION["loggedin"] = true;
        //這些是之後可以用到的變數
        $_SESSION["id"] = mysqli_fetch_assoc($result)["id"];
        $_SESSION["UID"] = mysqli_fetch_assoc($result)["UID"];
        header("location:welcome.php");
    }else{
            function_alert("帳號或密碼錯誤"); 
        }
}
    else{
        function_alert("Something wrong"); 
    }

    // Close connection
    mysqli_close($link);

function function_alert($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
     window.location.href='index.php';
    </script>"; 
    return false;
} 
?>
?>