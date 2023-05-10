<?php

// 建立資料庫連接
$conn = require_once "config.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    // 取出個人資料
    session_start();
    $UID = $_SESSION["UID"];
    $name = $_SESSION["name"];
    $lab = $_SESSION["lab"];
    $email = $_SESSION["email"];
    $phone = $_SESSION["phone"];

    $id = $_POST["id"];
    
    $sql = "SELECT * FROM `申請資料表` WHERE 申請表編號 = $id;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // $id = $row["申請表編號"];
    $classroom_id = $row["教室編號"];
    $borrow_date = $row["借用日期"];

    // 申請教室名稱
    $classroom_name = mysqli_query($conn, "SELECT * FROM `教室資料表` , `申請資料表` WHERE 教室資料表.教室編號 = $classroom_id;");
    $classroom_result = mysqli_fetch_assoc($classroom_name);
    $classroom = $classroom_result["教室名稱"];
    
    // 借用時段
    $time = "";
    $book_sql = "SELECT * FROM `借用時段` WHERE `教室編號` LIKE '$classroom_id'";
    $book_result = mysqli_query($conn, $book_sql);
    while($book_row = mysqli_fetch_assoc($book_result)) {
        $time = $time ." ". $book_row["已借用時段"];
    }

    // 借用設備
    $equipment = "";
    $equipment_sql = "SELECT * FROM `借用設備`,`申請資料表` WHERE 借用設備.申請表編號 = 申請資料表.申請表編號 AND 申請資料表.申請表編號 = '$id' ";
    $equipment_result = mysqli_query($conn, $equipment_sql);
    while($equipment_row = mysqli_fetch_assoc($equipment_result)) {
        $equipment = $equipment ." ". $equipment_row["借用設備"];
    }


    // 引入 TCPDF 函式庫
    require_once('tcpdf/tcpdf.php');

    // 創建新的 PDF 文件
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // 設置 PDF 文件屬性
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('');
    $pdf->SetSubject('Your Subject');
    $pdf->SetKeywords('Keywords');

    // 設置頁面邊界和頁碼
    $pdf->SetMargins(20, 20, 20);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(0);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(true, 0);

    // 添加內容
    $pdf->AddPage();
    $pdf->SetFont('msungstdlight', '', 14, '', false);
    // (寬度,高度,內容,邊框寬度,跳行,對齊,填充,超連結,拉伸,忽略最小高度,垂直對齊)

    $pdf->Cell(0, 10, '教室及設備申請表', 0, 1, 'C', 0, '', 0, false, 'T', 'C'); 
    // 申請資料
    $pdf->Cell(0, 10, '申請人資料', 0, 1, 'C', 0, '', 0, false, 'T', 'C'); 

    $pdf->Cell(0, 10, '學號：' . $UID, 1, 1, 'L', 0, '', 0, false, 'T', 'C'); 
    $pdf->Cell(0, 10, '姓名：' . $name, 1, 1, 'L', 0, '', 0, false, 'T', 'C'); 
    $pdf->Cell(0, 10, '所屬實驗室：' . $lab, 1, 1, 'L', 0, '', 0, false, 'T', 'C'); 
    $pdf->Cell(0, 10, 'Email：' . $email, 1, 1, 'L', 0, '', 0, false, 'T', 'C'); 
    $pdf->Cell(0, 10, '連絡電話：' . $phone, 1, 1, 'L', 0, '', 0, false, 'T', 'C'); 

    // 借用資料
    $pdf->Cell(0, 10, '借用資料', 0, 1, 'C', 0, '', 0, false, 'T', 'C'); 

    $pdf->Cell(0, 10, '申請表編號：' . $id , 1, 1, 'L', 0, '', 0, false, 'T', 'C'); 

    $pdf->Cell(0, 20, '申請教室：' .$classroom , 1, 1, 'L', 0, '', 0, false, 'T', 'C'); 
    $pdf->Cell(0, 10, '借用日期：' . $borrow_date, 1, 1, 'L', 0, '', 0, false, 'T', 'C'); 
    $pdf->Cell(0, 10, '借用節數：'. $time, 1, 1, 'L', 0, '', 0, false, 'T', 'C'); 
    $pdf->Cell(0, 10, '借用設備：' . $equipment, 1, 1, 'L', 0, '', 0, false, 'T', 'C'); 


    $pdf->Cell(0, 10, '借用人簽名：', 0, 1, 'L', 0, '', 0, false, 'T', 'C'); 
    $pdf->Cell(0, 10, '系辦人員簽名：', 0, 1, 'L', 0, '', 0, false, 'T', 'C'); 


    // 清除輸出緩衝區
    ob_end_clean();  
    // 輸出 PDF 文件
    $pdf->Output('yourfilename.pdf', 'I');
}

// 關閉與 MySQL 資料庫的連線
mysqli_close($conn);


?>
