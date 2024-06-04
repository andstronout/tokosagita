<?php
session_start();
require "config.php";
if (isset($_POST["submit"])) {
    $ubahProfil = ubahProfil();
}
if (!isset($_SESSION['login_pelanggan'])) {
    header("location:login.php");
}

$conn = koneksi();
$id = $_SESSION['id_pelanggan'];
$sql = $conn->query("SELECT * FROM user WHERE id_user='$id'");
$query = $sql->fetch_assoc();
include "header.php";
?>

<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="index.php"><i class="fa fa-home"></i> Home</a>
                    <span>Ubah Profile</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Form Section Begin -->

<!-- Register Section Begin -->
<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="register-form">
                    <h2>Register</h2>
                    <form action="#" method="post">
                        <div class="group-input">
                            <label for="nama_user">Nama Lengkap *</label>
                            <input type="text" id="nama_user" name="nama_user" value="<?= $query['nama_user']; ?>">
                        </div>
                        <div class="group-input">
                            <label for="email">Email address *</label>
                            <input type="text" id="email" name="email" value="<?= $query['email']; ?>">
                        </div>
                        <div class="group-input">
                            <label for="nomor_hp">Nomor Handphone *</label>
                            <input type="text" id="nomor_hp" name="nomor_hp" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="<?= $query['nomor_hp']; ?>">
                        </div>
                        <div class="group-input">
                            <label for="alamat">Alamat Lengkap</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="alamat"><?= $query['alamat']; ?></textarea>
                        </div>
                        <button type="submit" name="submit" class="site-btn register-btn">UBAH PROFILE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register Form Section End -->


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