<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>更改密碼</title>
    <link rel="stylesheet" type="text/css" href="change_password.css">
</head>
<body>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="old_password">舊密碼:</label>
    <input type="password" id="old_password" name="old_password"><br><br>
    <label for="new_password">新密碼:</label>
    <input type="password" id="new_password" name="new_password"><br>
    <input type="submit" value="更新密碼">
  </form>

  <!-- PHP -->
  <?php
  // 載入資料庫連線設定
  $conn = require_once "config.php";
  session_start();

  // 判斷是否有表單提交
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 取得使用者輸入的資料
    $UID = $_SESSION['UID'];
    $password = $_SESSION['password'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    // 確認舊密碼是否正確
    $check_sql = "SELECT `密碼` FROM `使用者資料表` WHERE `學號` = '$UID'";
    $result = mysqli_query($conn, $check_sql);
    $row = mysqli_fetch_assoc($result);
  //   $password_check = $row['密碼'];
    if ($old_password == $password) {
      // 更新使用者資料表中的密碼欄位
      // $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
      $sql = "UPDATE `使用者資料表` SET `密碼` = '$new_password' WHERE `學號` = '$UID'";
      if (mysqli_query($conn, $sql)) {
        function_alert("密碼已更新") ;
        $_SESSION['password'] = $new_password;
      } else {
        function_alert("更新失敗: " . mysqli_error($conn)) ;
      }
    } else {
      function_alert("舊密碼錯誤") ;
    }
  }


  
  // 上一頁
  echo "<a href=deparment.php>上一頁</a>";

  // 關閉資料庫連線
  mysqli_close($conn);
  ?>

</body>
</html>



<?php
// 跳出警示框顯示message，關閉警示框後跳轉回apply.php
function function_alert($message) { 
  // Display the alert box  
  echo 
  "<script>
  alert('$message');
  window.location.href='change_password.php';
  </script>"; 
  
  return false;
} 

?>

