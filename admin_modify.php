<!-- PHP -->

<?php
// 載入資料庫連線設定
$conn = require_once "config.php";

// 判斷是否有表單資料提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 取得表單資料
    $id = $_POST['id'];
    $name = $_POST['name'];
    $lab = $_POST['lab'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $permission = $_POST['permission'];
    
    if(isset($_POST['from_admin_modify']) && $_POST['from_admin_modify'] == 1){
        // 更新使用者資料
        $sql = "UPDATE `使用者資料表` 
                SET `實驗室名稱` = '$lab' , `密碼` = '$password', `Email` = '$email', `電話` = '$phone' , `權限` = '$permission' WHERE `學號` = '$id'";

        if (mysqli_query($conn, $sql)) {
            function_alert("使用者資料已更新");
        } 
        else {
            function_alert("更新失敗: " . mysqli_error($conn));
        }        
    }

} 

// 跳出警示框顯示message，關閉警示框後跳轉
function function_alert($message) { 
    // Display the alert box  
    echo 
    "<script>
    alert('$message');
    window.location.href='admin_check.php';
    </script>"; 
    
    return false;
}

// 關閉資料庫連線
mysqli_close($conn);
?>


<!-- HTML -->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>修改資料</title>
    <link rel="stylesheet" type="text/css" href="admin_modify.css">
  </head>
  <body>
    <h1>請選擇欲修改的資料</h1>

    <!-- 執行自己的php -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- 用來判斷從哪post -->
        <input type="hidden" name="from_admin_modify" value="1">

        <label for="id">學號:</label><br>
        <input type="text" id="id" name="id" value=<?php echo $id; ?> disabled><br>
        <input type="hidden" name="id" value=<?php echo $id; ?>>

        <label for="name">姓名:</label><br>
        <input type="text" id="name" name="name" value=<?php echo $name; ?> disabled><br>
        <input type="hidden" name="name" value=<?php echo $name; ?>>

        <label for="lab">實驗室名稱:</label><br>
        <input type="text" id="lab" name="lab" value=<?php echo $lab; ?>><br>

        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email" value=<?php echo $email; ?>><br>

        <label for="phone">電話:</label><br>
        <input type="text" id="phone" name="phone" value=<?php echo $phone; ?>><br>

        <label for="password">密碼:</label><br>
        <input type="text" id="password" name="password" value=<?php echo $password; ?>><br>

        <label for="permission">權限:</label><br>
        <input type="text" id="permission" name="permission" value=<?php echo $permission; ?>><br>

        <input type="submit" value="更新">
    </form>

    <a href="admin_check.php">上一頁</a>

  </body>
</html>
