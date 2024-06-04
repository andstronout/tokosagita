<?php
session_start();
require "config.php";
$conn = koneksi();
if (!isset($_SESSION['login_pelanggan'])) {
    header("location:login.php");
}

$sql_transaksi = sql("SELECT * FROM transaksi WHERE id_user='$_SESSION[id_pelanggan]' AND `status`='Belum Diproses' ORDER BY id_transaksi DESC");
include "header.php";
?>

<!-- Header Section Begin -->
<header class="header-section">
    <div class="nav-item" style="height: 60px;">
        <div class="container">
            <nav class="nav-menu mobile-menu d-flex justify-content-between">
                <ul>
                    <h2 class="text-white mt-2">SagitaCollection</h2>
                </ul>
                <ul>
                    <?php if (!isset($_SESSION['login_pelanggan'])) { ?>
                        <li><a href="login.php">Login</a>
                        <?php } else {
                        $sql_user = $conn->query("SELECT * FROM user WHERE id_user='$_SESSION[id_pelanggan]'");
                        $user = $sql_user->fetch_assoc();
                        ?>
                        <li><a href="#">Halo <?= $user['nama_user']; ?></a>
                            <ul class="dropdown">
                                <li><a href="./shopping-cart.php">Shopping Cart</a></li>
                                <li><a href="./pesanan_saya.php">Pesanan Saya</a></li>
                                <li><a href="./ubahpassword.php">Ubah Password</a></li>
                                <li><a href="./logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
            <div id="mobile-menu-wrap"></div>
        </div>
    </div>
</header>
<!-- Header End -->

<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="index.php"><i class="fa fa-home"></i> Home</a>
                    <span>Pesanan Belum Diproses</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Form Section Begin -->

<!-- Women Banner Section Begin -->
<section class="women-banner spad">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 offset-lg-1" style="margin-bottom: -80px;">
                <div class="filter-control">
                    <ul>
                        <li class="active text-dark">Belum Diproses</li>
                        <li><a href="pesanan_diproses.php" class="text-dark">Sedang Diproses</a></li>
                        <li><a href="pesanan_selesai.php" class="text-dark">Selesai Diproses</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Women Banner Section End -->

<div class="container">
    <div class="row border-bottom pt-4 d-flex justify-content-center align-items-center">
        <?php
        if ($sql_transaksi->num_rows > 0) {
            foreach ($sql_transaksi as $transaksi) { ?>
                <div class="row" style="width: 100%;">
                    <div class="col-10">
                        <h5>Pesanan : <?= $transaksi['id_pesanan']; ?> - ( <?= $transaksi['tanggal_transaksi']; ?> )</h5>
                    </div>
                </div>
                <?php
                $sql_detail = sql("SELECT * FROM detail_transaksi INNER JOIN transaksi ON detail_transaksi.id_transaksi=transaksi.id_transaksi INNER JOIN produk ON detail_transaksi.id_produk=produk.id_produk WHERE id_user='$_SESSION[id_pelanggan]' AND `status`='Belum Diproses' AND transaksi.id_transaksi='$transaksi[id_transaksi]'");
                foreach ($sql_detail as $detail) { ?>
                    <div class="row border-top border-bottom main d-flex justify-content-center align-items-center mx-4 mb-3">
                        <div class="col-2"><img class="img-fluid" src="img/produk/<?= $detail['gambar_produk']; ?>"></div>
                        <div class="col-5">
                            <div class="row text-muted"><?= $detail['jenis']; ?></div>
                            <div class="row"><?= $detail['nama_produk']; ?></div>
                        </div>
                        <div class="col-2">
                            <?= $detail['qty_transaksi']; ?> Pcs
                        </div>
                        <div class="col-2">
                            <?php echo 'Rp. ' . number_format($total_harga = $detail['harga_produk'] * $detail['qty_transaksi']); ?>
                        </div>
                    </div>
            <?php
                }
            } ?>
        <?php } else { ?>
            <div class="row border-top border-bottom main d-flex justify-content-center align-items-center mx-4">
                <div class=" alert alert-info mt-5 mb-3 text-center" role="alert">
                    Keranjang belanja kosong. Silahkan pilih barang terlebih dahulu. <a href="index.php#produk">Pilih Produk</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Footer Section Begin -->
<footer class="footer-section">\
    <div class="copyright-reserved">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-text text-center">
                        Copyright Sagita Collection &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

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