<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>歡迎頁面</title>
        <!-- <link rel="stylesheet" type="text/css" href="welcome.css"> -->
    </head>
    <body>
        <h1>系辦</h1>   
        <div class="container">
            <?php
            $conn = require_once "config.php";
            session_start();
            
            echo "<h2>你好 " . $_SESSION["name"] . "</h2>";
            echo "<a href='deparment_record.php'>學生申請紀錄</a><br>";
            echo "<a href='borrow_classroom.php' class='button'>查詢教室借用情況</a><br>";
            echo "<a href='change_password.php'>更改密碼</a><br>";
            echo "<a href='logout.php'>登出</a><br>";

            mysqli_close($conn);
            ?>
        </div>
    </body>
</html>
