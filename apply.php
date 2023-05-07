<!-- HTML -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>教室及設備申請表</title>
       
    </head>
    <body>
        <h1>教室及設備申請表</h1>
        <form name="ApplyForm" action="apply.php" method="POST">
            申請表編號:<br>
            <input type="text" name="form_no"><br>
            學號:<br>
            <input type="text" name="student_id"><br>
            借用人:<br>
            <input type="text" name="borrower"><br>      
            教室編號:<br>
            <input type="text" name="classroom_id"><br>
            用途:<br>
            <input type="text" name="purpose"><br>
            負責系辦:<br>
            <input type="text" name="department"><br> 

            <!-- 借用日期 -->
            <label for="borrow_date">借用日期：</label><br>
            <!-- 年 -->
            <select name="year">
              <?php
                for ($i = date("Y"); $i <= date("Y")+1; $i++) {
                  echo "<option value=\"$i\">$i</option>";
                }
              ?>
            </select>
            <!-- 月 -->
            <select name="month" onchange="updateDays()">
              <?php
                for ($i = 1; $i <= 12; $i++) {
                  echo "<option value=\"$i\">$i</option>";
                }
              ?>
            </select>
            <!-- 日 -->
            <select name="day">
              <?php
                $numDays = cal_days_in_month(CAL_GREGORIAN, date("n"), date("Y"));
                for ($i = 1; $i <= $numDays; $i++) {
                  echo "<option value=\"$i\">$i</option>";
                }
              ?>
            </select>
            <br>

            <!-- 借用時段 -->
            <label for="borrow_time">借用時段：</label><br>
            <select name="borrow_time" id="borrow_time">
                <option value="8:10-9:00">8:10-9:00</option>
                <option value="9:10-10:00">9:10-10:00</option>
                <option value="10:10-11:00">10:10-11:00</option>
                <!-- 其他選項 -->
            </select><br>

            <input type="submit" value="送出"/>   
        </form>
    </body>
</html>



<!-- PHP -->

<?php
// 建立資料庫連接
$conn = require_once "config.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

	// 獲取表單提交的數據
	$form_no = $_POST['form_no'];
	$classroom_id = $_POST['classroom_id'];
	$student_id = $_POST['student_id'];
	$purpose = $_POST['purpose'];
	$borrower = $_POST['borrower'];
  $department = $_POST['department'];
	
  // 借用日期
  $year = $_POST['year'];
  $month = $_POST['month'];
  $day = $_POST['day'];
  $borrow_date = date("Y-m-d", strtotime("$year-$month-$day"));
	// $borrow_date = $_POST['borrow_date'];

	$borrow_time = $_POST['borrow_time'];

	// 檢查借用時段是否有衝突
	$book_sql = "SELECT * FROM `借用時段` WHERE `教室編號`='$classroom_id' AND `已借用日期`='$borrow_date' AND `已借用時段`='$borrow_time'";
	$book_result = mysqli_query($conn, $book_sql);

	if (mysqli_num_rows($book_result) > 0) {
		// 如果借用時間已被預訂，則顯示錯誤信息
		function_alert("該時間段已被預訂，請選擇其他時段。");
	} 
	else {
		// 如果借用時間未被預訂，則插入一條新的借用申請
		$insert_sql = "INSERT INTO `申請資料表` (`申請表編號`, `教室編號`, `學號`, `用途`, `借用人`, `借用日期`, `負責系辦`, `借用時段`) 
		VALUES ('$form_no', '$classroom_id', '$student_id', '$purpose', '$borrower', '$borrow_date', '$department', '$borrow_time')";
		$insert_result = mysqli_query($conn, $insert_sql);

		if ($insert_result) {
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



<!-- JavaScript -->
<script>
  // 根據所選月份的實際天數來生成對應的選項
  function updateDays() {
    var year = document.getElementsByName("year")[0].value;
    var month = document.getElementsByName("month")[0].value;
    var numDays = new Date(year, month, 0).getDate();
    var daySelect = document.getElementsByName("day")[0];
    daySelect.innerHTML = "";
    for (var i = 1; i <= numDays; i++) {
      var option = document.createElement("option");
      option.value = i;
      option.text = i;
      daySelect.add(option);
    }
  }
  updateDays();
</script>