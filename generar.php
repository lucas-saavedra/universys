<?php
include('includes/db.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$dias_result = mysqli_query($conexion,"SELECT * FROM `dia`");

$array_letras=['A','B','C','D','E','F','G'];

while($rows = mysqli_fetch_assoc($dias_result ) ){
$sheet->setCellValue($array_letras[$rows['id']].'1', $rows['nombre']);

}


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="myfile.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');