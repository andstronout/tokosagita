<?php
session_start();
require "../config.php";
if (!isset($_SESSION["login_admin"])) {
  header("location:../login.php");
}
$id = $_GET["id"];

// Query untuk mengambil data detail transaksi, produk, dan user
$sql_transaksi = sql("
    SELECT transaksi.*, detail_transaksi.*, produk.*, user.*
FROM transaksi
INNER JOIN detail_transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi
INNER JOIN produk ON detail_transaksi.id_produk = produk.id_produk
INNER JOIN user ON transaksi.id_user = user.id_user
WHERE transaksi.id_transaksi = '$id';

");

$no = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resi Penjualan - SagitaCollection</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @media print {
      .no-print {
        display: none;
      }

      .container {
        margin-top: 0;
      }

      body {
        margin: 0;
        padding: 0;
      }
    }

    .print-button {
      margin-top: 20px;
    }

    .table th,
    .table td {
      text-align: center;
      vertical-align: middle;
    }

    .table td:last-child {
      text-align: right;
    }

    .footer-section {
      margin-top: 40px;
    }
  </style>
</head>

<body>
  <div class="container mt-5 mb-5">
    <div class="text-center">
      <h2>SagitaCollection</h2>
      <p>Kp. Margasari, Curug Kulon, Kec. Curug, Kabupaten Tangerang</p>
      <p>Tel: +62 812 1234 1243 | Email: admin@sagita.com</p>
    </div>

    <?php if ($transaksi = $sql_transaksi->fetch_assoc()) { ?>
      <div class="row mt-4">
        <div class="col-md-6">
          <h5>Nomor Resi: <strong>#<?= $id; ?></strong></h5>
          <h5>Tanggal: <strong><?= date("d F Y"); ?></strong></h5>
        </div>
        <div class="col-md-6 text-md-end">
          <h5>Nama Pelanggan: <strong><?= $transaksi['nama_user']; ?></strong></h5>
          <h5>Nomor Handphone: <strong><?= $transaksi['nomor_hp']; ?></strong></h5>
          <h5>Alamat: <strong><?= $transaksi['alamat']; ?></strong></h5>
        </div>
      </div>
    <?php } ?>

    <div class="row mt-4">
      <div class="col-md-12">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>No</th>
              <th>Nama Produk</th>
              <th>Kuantitas</th>
              <th>Harga Satuan</th>
              <th>Total Harga</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $total_bayar = 0;
            foreach ($sql_transaksi as $produk) :
              $subtotal = $produk['qty_transaksi'] * $produk['harga_produk'];
              $total_bayar += $subtotal;
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $produk['nama_produk']; ?></td>
                <td><?= $produk['qty_transaksi']; ?></td>
                <td>Rp. <?= number_format($produk['harga_produk']); ?></td>
                <td>Rp. <?= number_format($subtotal); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <h5><strong>Total:</strong></h5>
      </div>
      <div class="col-md-6 text-end">
        <h5><strong>Rp. <?= number_format($total_bayar); ?></strong></h5>
      </div>
    </div>

    <div class="footer-section row mt-5">
      <div class="col-md-6">
        <p>Terima Kasih Telah Berbelanja di SagitaCollection!</p>
      </div>
    </div>

    <div class="text-center no-print print-button">
      <button class="btn btn-primary" onclick="window.print()">Print Resi</button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>