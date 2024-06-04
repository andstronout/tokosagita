<?php
session_start();
require "config.php";
if (!isset($_SESSION['login_pelanggan'])) {
    header("location:login.php");
}
$sql_cart = sql("SELECT * FROM cart INNER JOIN produk ON cart.id_produk=produk.id_produk WHERE id_user='$_SESSION[id_pelanggan]'");
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
                    <span>Shopping Cart</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cart-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th class="p-name">Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $jumlah_bayar = 0; ?>
                            <?php foreach ($sql_cart as $cart) : ?>
                                <tr>
                                    <td class="cart-pic first-row"><img src="img/produk/<?= $cart['gambar_produk']; ?>" alt="" style="width: 200px;"></td>
                                    <td class="cart-title first-row">
                                        <h5><?= $cart['nama_produk']; ?></h5>
                                    </td>
                                    <td class="p-price first-row">Rp. <?= number_format($cart['harga_produk']); ?> ,-</td>
                                    <td class="cart-title first-row">
                                        <h5 class="text-center"><?= $cart['qty_cart']; ?></h5>
                                    </td>
                                    <td class="total-price first-row">Rp. <?= number_format($total_harga = $cart['qty_cart'] * $cart['harga_produk']); ?> ,-</td>
                                    <td class="close-td first-row"><a href="delete_cart.php?id=<?= $cart['id_cart']; ?>"><i class="ti-close"></i></a></td>
                                </tr>
                                <?php $jumlah_bayar += $total_harga; ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="cart-buttons">
                            <a href="index.php#shop" class="primary-btn continue-shop">Continue shopping</a>
                        </div>
                    </div>
                    <div class="col-lg-4 offset-lg-4">
                        <div class="proceed-checkout">
                            <ul>
                                <li class="subtotal">Subtotal <span>Rp. <?= number_format($jumlah_bayar); ?>,-</span></li>
                                <li class="cart-total">Total <span>Rp. <?= number_format($jumlah_bayar); ?>,-</span></li>
                            </ul>
                            <a href="check-out.php" class="proceed-btn">PROCEED TO CHECK OUT</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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