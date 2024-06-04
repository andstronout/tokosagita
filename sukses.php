<?php
require "config.php";
$id = $_GET["id"];
$sql = sql("SELECT * FROM transaksi WHERE id_transaksi='$id'");
$idt = $sql->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="images/favicon.png" type="">
  <title>Sagita Colection</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  <style>
    i {
      color: #9ABC66;
      font-size: 100px;
      line-height: 200px;
      margin-left: -15px;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="alert alert-success text-center">
          <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;" class="mb-3">
            <i class="checkmark">✓</i>
          </div>
          <h2>Checkout Berhasil!</h2>
          <p>Terima kasih telah melakukan pembayaran.</p>
          <p>Nomor pesanan Anda adalah: <strong><?= $idt['id_pesanan']; ?></strong></p>
          <a href="index.php" class="btn btn-success mb-3">Halaman Utama</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>