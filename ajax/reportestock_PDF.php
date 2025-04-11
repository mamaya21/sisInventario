<?php
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ("../config/db.php");
require_once ("../config/conexion.php");
require_once ("../vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

\Mpdf\Mpdf::class;

$consulta = $_GET["sql"];
$resultado = mysqli_query($con, $consulta);

if ($resultado->num_rows > 0) {
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

    $lastRow = $i - 1;

    // Estilo del título
    $sheet->getStyle('A1:H1')->applyFromArray([
        'font' => ['name' => 'Verdana', 'bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF220835']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    ]);

    // Estilo encabezado
    $sheet->getStyle('A3:H3')->applyFromArray([
        'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000']
            ]
        ]
    ]);

    // Estilo para celdas con bordes completos
    $sheet->getStyle("A4:H$lastRow")->applyFromArray([
        'font' => ['name' => 'Arial', 'color' => ['rgb' => '000000']],
        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000']
            ]
        ]
    ]);

    foreach (range('A', 'H') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $sheet->setTitle('Stock');
    $sheet->freezePane('A4');

    while (ob_get_level()) { ob_end_clean(); }

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="Reporte de Stock en línea.pdf"');
    header('Cache-Control: max-age=0');

    $writer = new Mpdf($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo 'No hay resultados para mostrar';
}
