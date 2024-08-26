<?php
session_start();
require "config.php";
$conn = koneksi();
$aksi_cart = cart();
$sql_produk = sql("SELECT * FROM produk");
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
                                <li><a href="./ubah_profil.php">Ubah Profile</a></li>
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

<!-- Hero Section Begin -->
<section class="hero-section">
    <div class="hero-items owl-carousel">
        <div class="single-hero-items set-bg" data-setbg="img/hero-1.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <span>Bag,kids</span>
                        <h1>Black friday</h1>
                        <h5 class="mb-2">Free Ongkir JABODETABEK</h5>
                        <a href="#shop" class="primary-btn">Shop Now</a>
                    </div>
                </div>
                <div class="off-card">
                    <h2>Sale <span>50%</span></h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Product Shop Section Begin -->
<section class="product-shop spad" id="shop">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="product-list">
                    <div class="row">
                        <?php foreach ($sql_produk as $produk) : ?>
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="img/produk/<?= $produk['gambar_produk']; ?>" alt="">
                                    </div>
                                    <div class="pi-text">
                                        <a href="#" class="mb-2">
                                            <h5><?= $produk['nama_produk']; ?></h5>
                                        </a>
                                        <div class="catagory-name"><?= $produk['jenis']; ?></div>
                                        <div class="product-price mb-2">
                                            Rp. <?= number_format($produk['harga_produk']); ?> ,-
                                        </div>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_produk" value="<?= $produk['id_produk']; ?>">
                                            <div class="d-flex justify-content-center">
                                                <input type="number" name="qty_cart" class="form-control mb-3" style="width: 60px;" value="1" min="1" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                                            </div>
                                            <?php if ($produk['qty_produk'] == 0) { ?>
                                                <p><i>Stock Habis</i></p>
                                            <?php } else { ?>
                                                <button type="submit" name="submit" class="btn btn-sm btn-info">Add to cart</button>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Section Begin -->
<footer class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer-left">
                    <div class="footer-logo">
                        <a href="#">
                            <h2 class="text-white mt-2">SagitaCollection</h2>
                        </a>
                    </div>
                    <ul>
                        <li>Address: Kp. Margasari, Curug Kulon, Kec. Curug, Kabupaten Tangerang.</li>
                        <li>Phone: +62 812 1234 1243</li>
                        <li>Email: admin@sagita.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-reserved">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-text">
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