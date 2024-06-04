<?php
session_start();
require "config.php";
$conn = koneksi();
if (!isset($_SESSION['login_pelanggan'])) {
    header("location:login.php");
}

$sql_cart = $conn->query("SELECT * FROM cart INNER JOIN produk ON cart.id_produk=produk.id_produk WHERE id_user='$_SESSION[id_pelanggan]'");
$total_harga = 0;
while ($cart = $sql_cart->fetch_assoc()) {
    $total_harga += $cart['harga_produk'] * $cart['qty_cart'];
}
$sql_user = $conn->query("SELECT * FROM user WHERE id_user='$_SESSION[id_pelanggan]'");
$user = $sql_user->fetch_assoc();

if (isset($_POST["checkout"])) {
    $id_user = $_SESSION['id_pelanggan'];
    $tanggal_transaksi = date("y-m-d");
    $total_transaksi = $total_harga;
    $status = 'Belum Diproses';

    $sumber = @$_FILES['bukti_gambar']['tmp_name'];
    $target = 'img/bukti_bayar/';
    $nama_bukti_bayar = @$_FILES['bukti_gambar']['name'];

    if (@$_FILES['bukti_gambar']['error'] > 0) {
        echo "
        <script>
        alert('Bukti Bayar Tidak Boleh Kosong!');
        </script>
        ";
    } else if (@$_FILES['bukti_gambar']['type'] != 'image/jpg' && @$_FILES['bukti_gambar']['type'] != 'image/png' && @$_FILES['bukti_gambar']['type'] != 'image/jpeg') {
        echo "
        <script>
        alert('Silahkan Upload Bukti Bayar Dengan Benar!');
        </script>
        ";
    } else {
        $pindah = move_uploaded_file($sumber, $target . $nama_bukti_bayar);
        $tambah_transaksi = $conn->query("INSERT INTO transaksi (id_user,tanggal_transaksi,total_transaksi,bukti_bayar,`status`) VALUES ('$id_user','$tanggal_transaksi','$total_transaksi','$nama_bukti_bayar','$status') ");
        $id_transaksi = $conn->insert_id;
        // var_dump($id_transaksi);

        $t = time();
        $id_pesanan = "NRJ" . $t;
        $update = sql("UPDATE transaksi SET id_pesanan='$id_pesanan' WHERE id_transaksi='$id_transaksi'");

        foreach ($sql_cart as $cart) {
            $tambah_detail = sql("INSERT INTO detail_transaksi (id_transaksi,id_produk,qty_transaksi) VALUES ('$id_transaksi','$cart[id_produk]','$cart[qty_cart]')");
            $total = $cart['qty_produk'] - $cart['qty_cart'];
            $update_stok = sql("UPDATE produk SET qty_produk='$total' WHERE id_produk='$cart[id_produk]'");
        }

        $hapus_cart = sql("DELETE FROM cart WHERE id_user='$id_user'");
        $url = "sukses.php?id=" . $id_transaksi;
        header("location:" . $url);
    }
}
include "header.php";
?>

<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                    <a href="./index.php#shop">Shop</a>
                    <span>Check Out</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad">
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data" class="checkout-form">
            <div class="row">
                <div class="col-lg-6">
                    <h4>Billing Details</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="fir">Full Name<span>*</span></label>
                            <input type="text" id="fir" value="<?= $user['nama_user']; ?>" disabled>
                        </div>
                        <div class="col-lg-12">
                            <label for="cun-name">E-mail</label>
                            <input type="text" id="cun-name" value="<?= $user['email']; ?>" disabled>
                        </div>
                        <div class="col-lg-12">
                            <label for="cun">Nomor Handphone<span>*</span></label>
                            <input type="text" id="cun" value="<?= $user['nomor_hp']; ?>" disabled>
                        </div>
                        <div class="col-lg-12">
                            <label for="street">Address<span>*</span></label>
                            <input type="text" id="street" class="street-first" value="<?= $user['alamat']; ?>" disabled>
                        </div>
                        <div class="col-lg-12">
                            <div class="alert alert-info" role="alert">
                                <b>Silahkan melakukan transfer pada nomor rekening dibawah</b>
                                <br>
                                BCA : 123123123 ( BCA ) <br>
                                Dana : 08123123123 <br>
                                A.N Agis Sagita
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="place-order">
                        <h4>Your Order</h4>
                        <div class="order-total">
                            <ul class="order-table">
                                <li>Product <span>Total</span></li>
                                <?php $jumlah_bayar = 0; ?>
                                <?php
                                $sql_cart->data_seek(0); // Reset pointer
                                while ($cart = $sql_cart->fetch_assoc()) : ?>
                                    <li class="fw-normal"><?= $cart['nama_produk']; ?> X <?= $cart['qty_cart']; ?> <span><?= number_format($total_harga = $cart['qty_cart'] * $cart['harga_produk']); ?></span></li>
                                    <?php $jumlah_bayar += $total_harga; ?>
                                <?php endwhile ?>
                                <li class="fw-normal">Subtotal <span>Rp. <?= number_format($jumlah_bayar); ?></span></li>
                                <li class="total-price">Total <span>Rp. <?= number_format($jumlah_bayar); ?></span></li>
                            </ul>
                            <label for="bukti_gambar">Masukan bukti pembayaran</label>
                            <input type="file" name="bukti_gambar" id="bukti_gambar" class="form-control" required>
                            <div class="order-btn">
                                <button type="submit" name="checkout" class="site-btn place-btn">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Shopping Cart Section End -->

<!-- Js Plugins -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/jquery.zoom.min.js"></script>
<script src="js/jquery.dd.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
</body>

</html>