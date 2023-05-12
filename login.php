<?php
// 處理登入(index.html)

// 引入資料庫連線
$conn = require_once "config.php";
 
// 接收從表單傳送過來的帳號和密碼
$UID = $_POST["UID"];
$password = $_POST["password"];

// 將密碼進行雜湊
$password_hash = password_hash($password,PASSWORD_DEFAULT);

// 當使用者提交了表單（HTTP方法為POST）時，將會觸發以下事件
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "SELECT * FROM 使用者資料表 WHERE 學號 = '$UID' ";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result); // mysqli_fetch_assoc($result)執行一次，就會讀取資料指標指向的下一筆資料。所以在第一次讀取完，下一次再讀取時，指標指向的是空的位置

    // 查詢返回一行，而且該行的密碼欄位和輸入的密碼一致
    if(mysqli_num_rows($result)==1 && $password==$row["密碼"]){
        // 建立一個新的session，將使用者的ID和帳號名稱存儲在session變數中
        session_start();
        $_SESSION["loggedin"] = true;
        // 之後可以用到的變數，存在session內
        $_SESSION["UID"] = $UID;
        $_SESSION["password"] = $password;
        $_SESSION["name"] = $row["姓名"];
        $_SESSION["lab"] = $row["實驗室名稱"];
        $_SESSION["email"] = $row["Email"];
        $_SESSION["phone"] = $row["電話"];
        $_SESSION["permission"] = $row["權限"];
        
        if($row["權限"] == "1"){
            header("location:deparment.php");
        }
        else if($row["權限"] == "0"){
            header("location:welcome.php");
        }
    }
    else{
        function_alert("帳號或密碼錯誤"); // 寫在register.php
    }
}
else{
    function_alert("Something wrong"); 
}

// Close connection
mysqli_close($link);

// 跳出警示框顯示message，關閉警示框後跳轉回index.html
function function_alert($message) { 
    // Display the alert box  
    echo 
    "<script>
    alert('$message');
    window.location.href='index.html';
    </script>"; 
    
    return false;
} 

?>