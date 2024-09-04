<?php
session_start();
require "../config.php";
require '../fpdf/fpdf.php'; // Pastikan file FPDF ada

if (!isset($_SESSION["login_admin"])) {
  header("location:../login.php");
  exit;
}

// Cek apakah session untuk tanggal ada, jika tidak, ambil semua data
$t_awal = $_SESSION['awal'] ?? '';
$t_akhir = $_SESSION['akhir'] ?? '';

// Buat query SQL
if ($t_awal && $t_akhir) {
  // Jika tanggal awal dan akhir ada
  $sql_query = "SELECT * FROM transaksi 
                INNER JOIN user ON transaksi.id_user=user.id_user 
                WHERE transaksi.tanggal_transaksi BETWEEN '$t_awal' AND '$t_akhir'
                ORDER BY transaksi.tanggal_transaksi";
} else {
  // Jika tidak ada filter tanggal, ambil semua data
  $sql_query = "SELECT * FROM transaksi 
                INNER JOIN user ON transaksi.id_user=user.id_user 
                ORDER BY transaksi.tanggal_transaksi";
}

// Eksekusi query
$sql_produk = sql($sql_query);

// Jika tidak ada data yang ditemukan
if (empty($sql_produk)) {
  echo "Tidak ada data transaksi pada rentang tanggal yang dipilih.";
  exit;
}

$pdf = new FPDF('P', 'mm', 'A4'); // Orientasi portrait, satuan mm, ukuran A4
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

// Menambahkan judul di atas tabel
$pdf->Cell(0, 10, 'Daftar Transaksi', 0, 1, 'C');
$pdf->SetFont('Arial', '', 7);
// Menampilkan periode berdasarkan filter tanggal
if ($t_awal && $t_akhir) {
  $pdf->Cell(0, 10, 'Periode: ' . date('d-m-Y', strtotime($t_awal)) . ' s/d ' . date('d-m-Y', strtotime($t_akhir)), 0, 1, 'C');
} else {
  $pdf->Cell(0, 10, 'Periode: All Data', 0, 1, 'C');
}

$pdf->Ln(10); // Tambahkan spasi sebelum tabel

// Buat header tabel
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(30, 10, 'Nomor Transaksi', 1);
$pdf->Cell(40, 10, 'Nama Pelanggan', 1);
$pdf->Cell(30, 10, 'Tanggal Transaksi', 1);
$pdf->Cell(30, 10, 'Resi', 1);
$pdf->Cell(20, 10, 'Status', 1);
$pdf->Cell(30, 10, 'Total Bayar', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 7);
$no = 1;
$total_bayar = 0;

foreach ($sql_produk as $transaksi) {
  $resi = $transaksi['no_resi'] ?? 'Belum ada resi';

  $pdf->Cell(10, 10, $no, 1);
  $pdf->Cell(30, 10, $transaksi['id_pesanan'], 1);
  $pdf->Cell(40, 10, $transaksi['nama_user'], 1);
  $pdf->Cell(30, 10, $transaksi['tanggal_transaksi'], 1);
  $pdf->Cell(30, 10, $resi, 1);
  $pdf->Cell(20, 10, $transaksi['status'], 1);
  $pdf->Cell(30, 10, 'Rp. ' . number_format($transaksi['total_transaksi']), 1);
  $pdf->Ln();

  $total_bayar += $transaksi['total_transaksi'];
  $no++;
}

// Tambahkan Total Bayar
$pdf->Cell(160, 10, 'TOTAL BAYAR', 1);
$pdf->Cell(30, 10, 'Rp. ' . number_format($total_bayar), 1);
$pdf->Ln();

// Output PDF
$pdf->Output();
