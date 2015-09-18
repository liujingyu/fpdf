<?php
header("Content-type:text/html;charset=utf-8");
require('chinese.php');

$order = array(
    'ctime' => '2015-09-11 12:12:12',
    'customer_name' => '才亮',
    'address' => '北京豪威大厦305A',
    'total_price' => 1212,
    'amount' => 38,
);

$data = array(
    array('goods_name' => '东北馆子', 'bar_code' => '21313123', 'goods_count' => 2, 'goods_price' => 12.12),
    array('goods_name' => '东北馆子2', 'bar_code' => '99921313123', 'goods_count' => 12, 'goods_price' => 112.12),
    array('goods_name' => '东北馆子3', 'bar_code' => '999xx21313123', 'goods_count' => 12, 'goods_price' => 112.12),
    array('goods_name' => '东北馆子4', 'bar_code' => '9xx9921313123', 'goods_count' => 12, 'goods_price' => 112.12),
);
$total_data = array('合计'.$order['amount'], '', '', '', '总价:'.$order['total_price']);

$mapNames = array(
    'ctime' => '订单时间',
    'customer_name' => '客户姓名',
    'address' => '地址',
    'goods_name' => '商品',
    'goods_price' => '单价',
    'goods_count' => '数量',
);

$pdf = new PDF_Chinese('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->AddGBFont('sinfang', '仿宋_GB2312');
$pdf->SetFont('sinfang', '', 8);

#顾客信息
$pdf->Cell(0, 8, iconv("UTF-8", "gbk//TRANSLIT", $mapNames['ctime'].":".$order['ctime']));
$pdf->Ln();
$pdf->Cell(20, 8, iconv("UTF-8", "gbk//TRANSLIT", $mapNames['customer_name'].":".$order['customer_name']));
$pdf->Ln();
$pdf->Cell(30, 8, iconv("UTF-8", "gbk//TRANSLIT", $mapNames['address'].":".$order['address']));
$pdf->Ln();

#商品信息
$w = array(16, 80, 30, 12, 30);
$header = array('序号', '商品', '条码', '数量', '单价');
// Header
foreach($header as $k => $col) {
    $pdf->Cell($w[$k], 6, iconv("UTF-8", "gbk//TRANSLIT", $col), "1", 0, 'C');
}
$pdf->Ln();

foreach ($data as $k => $row) {
    $pdf->Cell($w[0], 6, iconv("UTF-8", "gbk//TRANSLIT", $k+1), "LBR", 0, 'C');
    $pdf->Cell($w[1], 6, iconv("UTF-8", "gbk//TRANSLIT", $row['goods_name']), "LBR", 0, 'C');
    $pdf->Cell($w[2], 6, iconv("UTF-8", "gbk//TRANSLIT", $row['bar_code']), "LBR", 0, 'C');
    $pdf->Cell($w[3], 6, iconv("UTF-8", "gbk//TRANSLIT", $row['goods_count']), "LBR", 0, 'C');
    $pdf->Cell($w[4], 6, iconv("UTF-8", "gbk//TRANSLIT", $row['goods_price']), "LBR", 0, 'C');
    $pdf->Ln();
}

$pdf->Cell($w[0], 6, iconv("UTF-8", "gbk//TRANSLIT", $total_data[0]), "LB", 0, 'C');
$pdf->Cell($w[1], 6, iconv("UTF-8", "gbk//TRANSLIT", $total_data[1]), "B", 0, 'C');
$pdf->Cell($w[2], 6, iconv("UTF-8", "gbk//TRANSLIT", $total_data[2]), "B", 0, 'C');
$pdf->Cell($w[3], 6, iconv("UTF-8", "gbk//TRANSLIT", $total_data[3]), "B", 0, 'C');
$pdf->Cell($w[4], 6, iconv("UTF-8", "gbk//TRANSLIT", $total_data[4]), "BR", 0, 'C');
$pdf->Ln();

#打印
$pdf->Output();
