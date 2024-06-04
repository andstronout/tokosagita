<?php
require "config.php";
$id = $_GET["id"];

$ubah = sql("UPDATE transaksi SET `status`= 'Selesai' WHERE id_transaksi='$id'");
echo "
        <script>
        alert('Barang telah di terima!');
        document.location.href = 'pesanan_diproses.php';
        </script>
        ";
