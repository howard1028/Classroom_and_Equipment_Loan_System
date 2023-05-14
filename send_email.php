


<!DOCTYPE html>
<html>
<head>
    <title>send email</title>
    <meta charset='utf-8'>
    <script type='text/javascript' src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
</head>
<body>
    <?php
    // 測試寄信
    $conn = require_once "config.php";

    $today = date("Y-m-d");

    // 查詢所有尚未歸還的紀錄
    $sql = "SELECT * FROM `申請資料表` WHERE `歸還情況` LIKE '尚未歸還'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)){
        // 取得借用紀錄資料
        $borrow_date = $row['借用日期'];
        $borrower_id = $row['學號'];
        $borrower_name = $row['借用人'];

        $email_sql =  "SELECT * FROM `使用者資料表` WHERE 學號 LIKE '$borrower_id';";
        $email_result = mysqli_query($conn, $email_sql);
        $email_row = mysqli_fetch_assoc($email_result);
        $borrower_email = $email_row['Email'];
        
        // 判斷是否超過時間
        // if ($borrow_date > $today){

        //     function_alert("成功寄出!");
        // }
    }

    // 跳出警示框顯示message，關閉警示框後跳轉回
    function function_alert($message) { 
        // Display the alert box  
        echo 
        "<script>
        alert('$message');
        window.location.href='deparment.php';
        </script>";    
        return false;
    } 

    // 關閉資料庫連線
    // mysqli_close($conn);
    ?>


    <script type='text/javascript'>
        (function() {
            // 初始化 EmailJS SDK，使用已建立的服務(service)的 ID
            emailjs.init("Bgvw5npIQBXLchDZ-");

            // 發送郵件
            emailjs.send("service_z6r7xk4", "template_fqy4fl8", {
                to_name: "<?php echo $borrower_name; ?>",
                to_email: "<?php echo $borrower_email; ?>",
                from_name: "系辦",
                message: "您有借用的教室及設備尚未歸還，請盡速歸還!"
            })
            .then(function(response) {
                console.log("郵件已發送：", response);
            }, 
            function(error) {
                console.error("發生錯誤：", error);
            });
        })();
    </script>

    <h3 style='text-align: center'>Email發送成功!!</h3>
</body>
</html>
