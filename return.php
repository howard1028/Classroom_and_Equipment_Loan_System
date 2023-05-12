歸還
<?php

// 建立連線
$conn = require_once "config.php";

// 將申請表編號為$id的"歸還情況"欄位的值改成"已歸還"
$id = $_POST['id'];
$sql = "UPDATE 申請資料表 SET 歸還情況 = '已歸還' WHERE 申請表編號 = '$id'";

if (mysqli_query($conn, $sql)) {
  function_alert("歸還成功");
} 
else {
  function_alert("Error updating record: " . mysqli_error($conn));
}

// 關閉連線
mysqli_close($conn);

// 跳出警示框顯示message，關閉警示框後跳轉回
function function_alert($message) { 
    // Display the alert box  
    echo 
    "<script>
    alert('$message');
    window.location.href='deparment_record.php';
    </script>"; 
    
    return false;
} 


?>

