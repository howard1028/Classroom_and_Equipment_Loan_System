<?php
// 初始化Session
session_start();

// 檢查使用者是否已經登入
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    // exit;  //跳一次停
}
else{ 
    function_alert("尚未登入");
    exit;  //跳一次停
}

// 跳出警示框顯示message，關閉警示框後跳轉回index.html
function function_alert($message) { 
    // Display the alert box  
    echo 
    "<script>
    alert('$message');
    window.location.href='index.html';
    </script>"; 
    
    return false;
} 
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>學生</title>
        <link rel="stylesheet" type="text/css" href="welcome.css">
    </head>
    <body>
        <h1>歡迎頁面</h1>   
        <div class="container">
            <?php
            $conn = require_once "config.php";
            // session_start();
            echo "<h2>你好 " . $_SESSION["name"] . "</h2>";
            echo "<a href='borrow_classroom.php' class='button'>查詢教室借用情況</a><br>";
            echo "<a href='apply.php' class='button'>申請教室借用</a><br>";
            echo "<a href='apply_record.php' class='button'>申請紀錄</a><br>";
            echo "<a href='logout.php' class='button'>登出</a><br>";
            
            mysqli_close($conn);
            ?>
        </div>
    </body>
</html>
