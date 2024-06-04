<?php
require 'config.php';
$id = $_GET['id'];
$hapus = sql("DELETE FROM cart WHERE id_cart ='$id'");

echo "
      <script>
      alert('Produk dihapus dari Keranjang!');
      document.location.href = 'shopping-cart.php';
      </script>
      ";
