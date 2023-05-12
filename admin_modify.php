<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <label for="old_password">學號:</label>
  <input type="text" id="new_id" name="old_password" value=<?php echo $id; ?>><br>

  <label for="old_password">實驗室名稱:</label>
  <input type="text" id="old_password" name="old_password"><br>
  
  <label for="old_password">Email:</label>
  <input type="text" id="old_password" name="old_password"><br>

  <label for="old_password">電話:</label>
  <input type="text" id="old_password" name="old_password"><br>
  
  <label for="new_password">密碼:</label>
  <input type="text" id="new_password" name="new_password"><br>

  <label for="old_password">權限:</label>
  <input type="text" id="old_password" name="old_password"><br>
  

  <input type="submit" value="更新密碼">
</form>


<?php
// 載入資料庫連線設定
$conn = require_once "config.php";

// 判斷是否有表單資料提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 取得表單資料
    $id = $_POST['id'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // 更新使用者資料
    $sql = "UPDATE `使用者資料表` SET `姓名` = '$name', `密碼` = '$password', `Email` = '$email', `電話` = '$phone' WHERE `學號` = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "使用者資料已更新";
    } else {
        echo "更新失敗: " . mysqli_error($conn);
    }
} else {
    // 取得要修改的使用者的學號和密碼
    $id = $_GET['id'];
    $password = $_GET['password'];

    // 查詢要修改的使用者的資料
    $sql = "SELECT * FROM `使用者資料表` WHERE `學號` = '$id' AND `密碼` = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // 顯示表單讓管理員修改使用者資料
    echo '<form action="admin_modify.php" method="POST">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '<input type="hidden" name="password" value="' . $password . '">';
    echo '姓名：<input type="text" name="name" value="' . $row['姓名'] . '"><br>';
    echo '密碼：<input type="password" name="password" value="' . $row['密碼'] . '"><br>';
    echo 'Email：<input type="email" name="email" value="' . $row['Email'] . '"><br>';
    echo '電話：<input type="tel" name="phone" value="' . $row['電話'] . '"><br>';
    echo '<input type="submit" value="修改">';
    echo '</form>';
}

// 關閉資料庫連線
mysqli_close($conn);
?>
