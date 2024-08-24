<?php
$id = $_GET["id"];
require "../config.php";
$hapus = sql("UPDATE transaksi SET `status`='Cancel' WHERE id_transaksi='$id'");
echo "
            <script>
            alert('Cancel Berhasil ');
            document.location.href='daftar_transaksi.php';
            </script>
            ";
