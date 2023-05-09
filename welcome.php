<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>歡迎頁面</title>
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
</head>
<body>
    <div class="container">
        <h1>歡迎頁面</h1>
        <?php
        $conn = require_once "config.php";
        session_start();
        echo "<h2>你好 " . $_SESSION["name"] . "</h2>";
        echo "<a href='logout.php' class='button'>登出</a><br>";
        echo "<a href='borrow_classroom.php' class='button'>查詢教室借用情況</a><br>";
        echo "<a href='apply.php' class='button'>申請教室借用</a><br>";
        echo "<a href='apply_record.php' class='button'>申請紀錄</a><br>";
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
