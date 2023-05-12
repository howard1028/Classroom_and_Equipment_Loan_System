<?php
// 處理註冊(register.html)

$conn = require_once "config.php";

// 收到來自表單的 POST 請求 (沒寫這個條件，這段程式碼將在每次頁面載入時都被執行)
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $UID = $_POST["UID"];
    $name = $_POST["name"];
    $lab = $_POST["lab"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    
    // echo "學號:" . $UID . "<br>";
    // echo "姓名" . $name;
    // echo $lab;
    // echo $email;
    // echo $phone;
    // echo $password;

    //檢查帳號是否重複 (sql語法的表格名稱和欄位名稱要用反引號 ` 包覆，變數用 ' )
    $check="SELECT * FROM `使用者資料表` WHERE `學號` = '$UID' ";
    if(mysqli_num_rows(mysqli_query($conn,$check))==0){
        $sql="INSERT INTO `使用者資料表` (`學號`,`姓名`,`實驗室名稱`,`Email`,`電話`,`密碼`,`權限`)
            VALUES('$UID','$name','$lab','$email','$phone','$password','0')";
        
        if(mysqli_query($conn, $sql)){
            echo "註冊成功!3秒後將自動跳轉頁面<br>";
            echo "<a href='index.php'>未成功跳轉頁面請點擊此</a>";
            header("refresh:3; url=index.html");
            exit;
        }
        else{
            echo "Error creating table: " . mysqli_error($conn);
        }
    }
    else{
        echo "該帳號已有人使用!<br>3秒後將自動跳轉頁面<br>";
        echo "<a href='register.html'>未成功跳轉頁面請點擊此</a>";
        header('HTTP/1.0 302 Found');
        //header("refresh:3;url=register.html",true);
        exit;
    }
}

// 關閉與 MySQL 資料庫的連線
mysqli_close($conn);

?>
