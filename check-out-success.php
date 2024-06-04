<?php
session_start();
require "config.php";
$id = $_GET["id"];
$sql = sql("SELECT * FROM transaksi WHERE id_transaksi='$id'");
$idt = $sql->fetch_assoc();
include "header.php"; ?>

<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                    <a href="./index.php#shop">Shop</a>
                    <span>Success</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad">
    <div class="container">
        <form action="#" class="checkout-form">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 ">
                    <div class="place-order">
                        <div class="order-total">
                            <h4>Your Order Success</h4>
                            <p class="mb-3">Your order number : <?= $idt['id_pesanan']; ?></p>
                            <a href="index.php" class="btn btn-outline-primary">Halaman Utama</a>
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