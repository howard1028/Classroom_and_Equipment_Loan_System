<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>歡迎頁面</title>
        <!-- <link rel="stylesheet" type="text/css" href="welcome.css"> -->
    </head>
    <body>
        <h1>系統管理員</h1>   
        <div class="container">
            <?php
            $conn = require_once "config.php";
            session_start();
            
            echo "<h2>你好 " . $_SESSION["name"] . "</h2>";

            echo "<a href='admin_check.php'>管理使用者帳號與密碼</a><br>";
            echo "<a href='logout.php'>登出</a><br>";

            mysqli_close($conn);
            ?>
        </div>
    </body>
</html>
