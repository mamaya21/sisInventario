<?php
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ("../config/db.php");
require_once ("../config/conexion.php");
require_once ("../vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$consulta = $_GET["sql"];
$resultado = mysqli_query($con, $consulta);

if ($resultado->num_rows > 0) {
    if (PHP_SAPI == 'cli') die('Este archivo solo se puede ver desde un navegador web');

    $spreadsheet = new Spreadsheet();
    $spreadsheet->getProperties()
        ->setCreator("ALMACEN EXPRESS")
        ->setLastModifiedBy("ALMACEN EXPRES")
        ->setTitle("Reporte Excel")
        ->setSubject("Reporte Excel")
        ->setDescription("Reporte de Stock en línea")
        ->setKeywords("reporte destina")
        ->setCategory("Reporte excel");

    $sheet = $spreadsheet->getActiveSheet();
    $sheet->mergeCells('A1:H1');
    $sheet->setCellValue('A1', "Reporte de Stock en línea");
    $sheet->setCellValue('A3', 'FECHA');
    $sheet->setCellValue('B3', 'COD. MATERIAL');
    $sheet->setCellValue('C3', 'MATERIAL');
    $sheet->setCellValue('D3', 'TIPO');
    $sheet->setCellValue('E3', 'UNIDAD');
    $sheet->setCellValue('F3', 'CANT. ACTUAL');
    $sheet->setCellValue('G3', 'ULT. MOVIMIENTO');
    $sheet->setCellValue('H3', 'ULT, CANT. MOVIMIENTO');

    $i = 4;
    while ($fila = mysqli_fetch_array($resultado)) {
        $sheet->setCellValue('A' . $i, $fila['fecha']);
        $sheet->setCellValue('B' . $i, $fila['id_material']);
        $sheet->setCellValue('C' . $i, $fila['nombre']);
        $sheet->setCellValue('D' . $i, $fila['tipo']);
        $sheet->setCellValue('E' . $i, $fila['unidad']);
        $sheet->setCellValue('F' . $i, $fila['cantidad_actual']);
        $sheet->setCellValue('G' . $i, $fila['ultimo_movimiento']);
        $sheet->setCellValue('H' . $i, $fila['ultima_cantidad_movimiento']);
        $i++;
    }

    $estiloTituloReporte = [
        'font' => ['name' => 'Verdana', 'bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF220835']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    ];
    $sheet->getStyle('A1:F1')->applyFromArray($estiloTituloReporte);

    $estiloTituloColumnas = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => [
            'fillType' => Fill::FILL_GRADIENT_LINEAR,
            'rotation' => 80,
            'startColor' => ['rgb' => '7CFC00'],
            'endColor' => ['argb' => '7CFC00']
        ],
        'borders' => [
            'top' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '143860']]
        ],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    ];
    $sheet->getStyle('A3:H3')->applyFromArray($estiloTituloColumnas);

    $sheet->getStyle("A4:H" . ($i - 1))->applyFromArray([
        'font' => ['name' => 'Arial', 'color' => ['rgb' => '000000']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFFF']],
        'borders' => [
            'left' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '3a2a47']]
        ]
    ]);

    foreach (range('A', 'H') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $sheet->setTitle('Movimientos');
    $sheet->freezePane('A4');

    while (ob_get_level()) { ob_end_clean(); }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte de Stock en línea.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo 'No hay resultados para mostrar';
}
