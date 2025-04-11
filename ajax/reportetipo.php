<?php
ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cargar autoload y configuración
require_once '../libraries/PhpSpreadsheet/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Settings;
use MyCache\ArrayCache;

// Configurar caché
Settings::setCache(new ArrayCache());

// Crear hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Tipos de Material");

// Agregar encabezados
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Estado');

// Agregar datos estáticos
$data = [
    [1, 'Cable Coaxial', 'Activo'],
    [2, 'Canaleta Plástica', 'Activo'],
    [3, 'Tubos Conduit', 'Inactivo'],
];

$row = 2;
foreach ($data as $item) {
    $sheet->setCellValue("A{$row}", $item[0]);
    $sheet->setCellValue("B{$row}", $item[1]);
    $sheet->setCellValue("C{$row}", $item[2]);
    $row++;
}

// Ajuste automático de columnas
foreach (range('A', 'C') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Descargar como Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte_tipos_material.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
