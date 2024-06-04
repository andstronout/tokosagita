<?php
session_start();
require "../config.php";
if (!isset($_SESSION["login_admin"])) {
  header("location:../login.php");
}
if (isset($_POST["submit"])) {
  $nama_produk = $_POST["nama_produk"];
  $jenis = $_POST["jenis"];
  $harga_produk = $_POST["harga_produk"];
  $qty_produk = $_POST["qty_produk"];

  $sumber = @$_FILES['produk']['tmp_name'];
  $target = '../img/produk/';
  $nama = @$_FILES['produk']['name'];
  $pecah = explode('.', $nama);
  $time = time();
  $nama_gambar = $time . '.' . $pecah[1];

  if (@$_FILES['produk']['error'] > 0) {
    echo "
      <script>
      alert('Gambar Produk Tidak Boleh Kosong!');
      </script>
      ";
  } else if (@$_FILES['produk']['type'] != 'image/jpg' && @$_FILES['produk']['type'] != 'image/png' && @$_FILES['produk']['type'] != 'image/jpeg') {
    echo "
      <script>
      alert('Silahkan Upload Gambar Produk Dengan Benar!');
      </script>
      ";
  } else {
    $pindah = move_uploaded_file($sumber, $target . $nama_gambar);
    $tambah = sql("INSERT INTO produk (nama_produk,jenis,harga_produk,qty_produk,gambar_produk) VALUES ('$nama_produk','$jenis','$harga_produk','$qty_produk','$nama_gambar')");
    echo "
      <script>
      alert('Produk berhasil ditambahkan');
      document.location.href='daftar_produk.php';
      </script>
      ";
  }
}
include "header.php";
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Produk</h1>
  </div>

  <!-- Content Row -->
  <!-- Data Table -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="nama_produk" class="form-label">Nama Produk</label>
          <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama Produk" required>
        </div>
        <div class="mb-3">
          <label for="jenis" class="form-label">Jenis Barang</label>
          <select class="form-select" name="jenis" required>
            <option selected disabled>Pilih jenis Barang</option>
            <option value="Towel">Towel</option>
            <option value="Jaket">Jaket</option>
            <option value="Celana">Celana</option>
            <option value="T-shirt">T-shirt</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="harga_produk" class="form-label">Harga Produk</label>
          <input type="text" class="form-control" id="harga_produk" name="harga_produk" placeholder="Harga Produk" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
        </div>
        <div class="mb-3">
          <label for="qty_produk" class="form-label">Qty Produk</label>
          <input type="text" class="form-control" id="qty_produk" name="qty_produk" placeholder="Qty Produk" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
        </div>
        <div class="mb-3">
          <label for="formFile" class="form-label">Gambar Produk</label>
          <input class="form-control" type="file" id="formFile" name="produk" required>
        </div>
        <a href="daftar_produk.php" class="btn btn-outline-secondary">Kembali ke daftar</a>
        <button type="submit" name="submit" class="btn btn-primary" style="width: 150px;">Submit</button>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; SagitaCollection 2024</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="../logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../sbadmin/vendor/jquery/jquery.min.js"></script>
<script src="../sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../sbadmin/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="../sbadmin/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="../sbadmin/js/demo/chart-area-demo.js"></script>
<script src="../sbadmin/js/demo/chart-pie-demo.js"></script>

</body>

</html>