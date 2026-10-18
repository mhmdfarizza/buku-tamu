<?php
include('koneksi.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->mergeCells('A1:G1');
$sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('A1', 'Laporan Buku-Tamu');
$sheet->setCellValue('A2', 'No');
$sheet->setCellValue('B2', 'TANGGAL');
$sheet->setCellValue('C2', 'NAMA TAMU');
$sheet->setCellValue('D2', 'ALAMAT');
$sheet->setCellValue('E2', 'NO TELEPON/HP');
$sheet->setCellValue('F2', 'BERTEMU DENGAN');
$sheet->setCellValue('G2', 'KEPENTINGAN');

if (isset($_GET['cari'])) {
    $p_awal = $_GET['p_awal'];
    $p_akhir = $_GET['p_akhir'];
    $data = mysqli_query($koneksi, "SELECT * FROM buku_tamu WHERE tanggal BETWEEN '$p_awal' AND '$p_akhir'");
} else {
    $data = mysqli_query($koneksi, "SELECT * FROM buku_tamu");
}

$i = 3;
$no = 1;

while ($d = mysqli_fetch_array($data)) {
    $sheet->setCellValue('A' . $i, $no++);
    $sheet->setCellValue('B' . $i, $d['tanggal']);
    $sheet->setCellValue('C' . $i, $d['nama_tamu']);
    $sheet->setCellValue('D' . $i, $d['alamat']);
    $sheet->setCellValue('E' . $i, $d['no_hp']);
    $sheet->setCellValue('F' . $i, $d['bertemu']);
    $sheet->setCellValue('G' . $i, $d['kepentingan']);
    $i++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('Laporan Buku Tamu.xlsx');
echo "<script>window.location='Laporan Buku Tamu.xlsx'</script>";
?>