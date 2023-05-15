
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>修改資料</title>
    <link rel="stylesheet" type="text/css" href="apply_record.css">
  </head>
  <body>
    <h1>請選擇欲修改的資料</h1>
    <?php
    // 載入資料庫連線設定
    $conn = require_once "config.php";

    // 檢查使用者是否有管理員權限
    session_start();
    if ($_SESSION['permission'] != '2') {
      echo "您沒有管理員權限";
      exit();
    }

    // 列出所有使用者的資料
    $sql = "SELECT * FROM `使用者資料表` WHERE `權限` <> 2;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      echo "<table border='1'>";
      echo "<tr>
                <th>學號</th>
                <th>姓名</th>
                <th>實驗室名稱</th>
                <th>Email</th>
                <th>電話</th>
                <th>密碼</th>
                <th>權限</th>
                <th>修改個人資料</th>
            </tr>";
      while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["學號"] . "</td>";
        echo "<td>" . $row["姓名"] . "</td>";
        echo "<td>" . $row["實驗室名稱"] . "</td>";
        echo "<td>" . $row["Email"] . "</td>";
        echo "<td>" . $row["電話"] . "</td>";
        echo "<td>" . $row["密碼"] . "</td>";
        echo "<td>" . $row["權限"] . "</td>";

        echo '<td>';
        echo '<form action="admin_modify.php" method="POST">';

        echo '<input type="hidden" name="id" value="' . $row["學號"] . '">';
        echo '<input type="hidden" name="name" value="' . $row["姓名"] . '">';
        echo '<input type="hidden" name="lab" value="' . $row["實驗室名稱"] . '">';
        echo '<input type="hidden" name="email" value="' . $row["Email"] . '">';
        echo '<input type="hidden" name="phone" value="' . $row["電話"] . '">';
        echo '<input type="hidden" name="password" value="' . $row["密碼"] . '">';
        echo '<input type="hidden" name="permission" value="' . $row["權限"] . '">';
        
        echo '<input type="submit" value="修改">';
        echo '</form></td>';

        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "沒有使用者資料";
    }

    echo "<a href='admin.php'>上一頁</a>";

    // 關閉資料庫連線
    mysqli_close($conn);
    ?>
  </body>
</html>

