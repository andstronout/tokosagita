<?php
session_start();
require "../config.php";

if (!isset($_SESSION["login_owner"])) {
  header("location:../login.php");
}

// Filter berdasarkan tanggal
$t_awal = $_SESSION['awal'] ?? '';
$t_akhir = $_SESSION['akhir'] ?? '';

// Ambil data transaksi berdasarkan filter tanggal
$sql_produk = sql("SELECT * FROM transaksi 
    INNER JOIN user ON transaksi.id_user=user.id_user 
    WHERE transaksi.tanggal_transaksi BETWEEN '$t_awal' AND '$t_akhir'
    ORDER BY transaksi.tanggal_transaksi");

if (empty($sql_produk)) {
  echo "Tidak ada data transaksi pada rentang tanggal yang dipilih.";
  exit;
}

// Set header untuk file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=data_transaksi.xls");

// Menampilkan judul di atas tabel
echo "<h2>Daftar Transaksi</h2>";
echo "<p>Periode: " . date('d-m-Y', strtotime($t_awal)) . " s/d " . date('d-m-Y', strtotime($t_akhir)) . "</p>";

// Buat tabel untuk export
echo "<table border='1'>
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Transaksi</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal Transaksi</th>
            <th>Resi Pengiriman</th>
            <th>Status</th>
            <th>Total Bayar</th>
        </tr>
    </thead>
    <tbody>";

$no = 1;
$total_bayar = 0;

foreach ($sql_produk as $transaksi) {
  $resi = $transaksi['no_resi'] ?? 'Belum ada resi';

  echo "<tr>
        <td>{$no}</td>
        <td>{$transaksi['id_pesanan']}</td>
        <td>{$transaksi['nama_user']}</td>
        <td>{$transaksi['tanggal_transaksi']}</td>
        <td>{$resi}</td>
        <td>{$transaksi['status']}</td>
        <td>Rp. " . number_format($transaksi['total_transaksi']) . "</td>
    </tr>";

  $total_bayar += $transaksi['total_transaksi'];
  $no++;
}

echo "<tr>
        <td colspan='6'><strong>TOTAL BAYAR</strong></td>
        <td><strong>Rp. " . number_format($total_bayar) . "</strong></td>
    </tr>";

echo "</tbody></table>";
