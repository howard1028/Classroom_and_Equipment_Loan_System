<!------------------------------------------------ PHP ------------------------------------------------>
申請表
<?php
// 建立資料庫連接
$conn = require_once "config.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){


  session_start();
  $student_id = $_SESSION['UID'];
  $borrower = $_SESSION['name'];
  $classroom_id = $_POST['classroom_id'];
  $borrow_date = $_POST['borrow_date'];
  $_SESSION["date"] = $borrow_date;

  // 借用時段
  $borrow_time = $_POST['borrow_time'];
  // 檢查借用時段是否有衝突
  $book_sql = "SELECT * FROM `借用時段` WHERE `教室編號`='$classroom_id' AND `已借用日期`='$borrow_date' "; // 還要檢查節數
  $book_result = mysqli_query($conn, $book_sql);


  if (mysqli_num_rows($book_result) > 0) {
    // 如果借用時間已被預訂，則顯示錯誤信息
    function_alert("該時間段已被預訂，請選擇其他時段。");
  } 
  else {
    // 如果借用時間未被預訂，則插入一條新的借用申請
    $apply_sql = "INSERT INTO `申請資料表` ( `教室編號`, `學號`, `借用人`,`借用日期`,`審核情況`) 
    VALUES ( '$classroom_id', '$student_id', '$borrower', '$borrow_date' , '待審核')";
    $apply_result = mysqli_query($conn, $apply_sql);
    // 插入申請表編號
    $id_sql = "SELECT * FROM `申請資料表` WHERE 學號 like '$student_id' AND 借用人 like '$borrower' AND 借用日期 like '$borrow_date'";
    $id_result = mysqli_query($conn, $id_sql);
    $id = mysqli_fetch_assoc($id_result)["申請表編號"];

    // 取出checkbox borrow_time的值
    if(isset($_POST['borrow_time'])) {
      foreach($_POST['borrow_time'] as $selected_period) {
        $sql = "INSERT INTO `借用時段` ( `申請表編號`,`教室編號`,`已借用日期`,`已借用時段`)
        VALUES ( '$id','$classroom_id','$borrow_date','$selected_period')";
        $result = mysqli_query($conn, $sql);
      }
    }
    // 取出checkbox borrow_equipment的值
    if(isset($_POST['borrow_equipment'])) {
      foreach($_POST['borrow_equipment'] as $selected_equipment) {
        $sql = "INSERT INTO `借用設備` ( `申請表編號`,`借用設備`) 
        VALUES ( '$id','$selected_equipment')";
        $result = mysqli_query($conn, $sql);
      }
    }

    if ($apply_result) {
      // 如果插入成功，則顯示成功信息
      function_alert("申請成功，請等待系辦審核。");
    } 
    else {
      // 如果插入失敗，則顯示錯誤信息
      function_alert("申請失敗，請重試。");
    }
  }
}


// 跳出警示框顯示message，關閉警示框後跳轉回apply.php
function function_alert($message) { 
  // Display the alert box  
  echo 
  "<script>
  alert('$message');
  window.location.href='apply.php';
  </script>"; 
  
  return false;
} 


// 關閉資料庫連接
mysqli_close($conn);
?>



<!------------------------------------------------ HTML ------------------------------------------------>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>教室及設備申請表</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>教室及設備申請表</h1>
        <form name="ApplyForm" action="apply.php" method="POST">
            <!-- 申請表編號:<br>
            <input type="text" name="form_no"><br> -->
            學號:<br>
            <input type="text" name="student_id" value="<?php session_start(); echo $_SESSION["UID"]; ?>" disabled><br>
            借用人:<br>
            <input type="text" name="borrower" value="<?php echo $_SESSION["name"]; ?>" disabled><br>   
    
            教室編號:<br>
            <!-- 有空改動態 -->
            <select name="classroom_id" id="classroom_id" required>
              <option value>請選擇教室</option>
              <option value="1">EC5008</option>
              <option value="2">EC5009</option>
              <option value="3">EC5010</option>
              <option value="4">EC9009</option>
            </select> <br>
            
            <!-- 借用日期 -->
            借用日期:<br>
            <input type="date" name="borrow_date" min="<?php echo date('Y-m-d'); ?>"  required><br>
            
            <!-- <input type="submit" name="inquiry" value="查詢"/><br> -->

            <!-- 借用時段 -->
            <label for="borrow_time">借用時段：</label><br>
              <input type="checkbox" name="borrow_time[]" value="1">第一節 8:00-8:59<br>
              <input type="checkbox" name="borrow_time[]" value="2">第二節 9:00-9:59<br>
              <input type="checkbox" name="borrow_time[]" value="3">第三節 10:00-10:59<br>
            <br>

            <!-- 借用設備 -->
            <label for="borrow_equipment">借用設備：</label><br>
              <input type="checkbox" name="borrow_equipment[]" value="麥克風">麥克風<br>
              <input type="checkbox" name="borrow_equipment[]" value="轉接頭">轉接頭<br>
              <input type="checkbox" name="borrow_equipment[]" value="滑鼠">滑鼠<br>
            <br>

            <input type="submit" name="send" value="送出"/>   
        </form>
    </body>
</html>


<!------------------------------------------------ JavaScript ------------------------------------------------>

<script>
  // 至少有一個借用時段被勾選，若沒有則阻止表單提交
  const form = document.querySelector('form');
  const borrowTimeCheckboxes = form.querySelectorAll('input[name="borrow_time[]"]');
  const borrowTimeError = document.querySelector('#borrow-time-error');

  form.addEventListener('submit', (event) => {
    let isBorrowTimeSelected = false;
    borrowTimeCheckboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        isBorrowTimeSelected = true;
      }
    });

    if (!isBorrowTimeSelected) {
      event.preventDefault(); // 阻止表單提交
      borrowTimeError.style.display = 'inline'; // 顯示錯誤訊息
    }
  });

</script>