<?php
// 引入 TCPDF 函式庫
require_once('tcpdf/tcpdf.php');

// 創建新的 PDF 文件
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// 設置 PDF 文件屬性
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Your Title');
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
$pdf->SetFont('cid0jp', '', 14, '', false);
$pdf->Cell(0, 10, 'Your content goes here', 0, 1, 'C', 0, '', 0, false, 'T', 'C');

// 輸出 PDF 文件
$pdf->Output('yourfilename.pdf', 'I');
?>
