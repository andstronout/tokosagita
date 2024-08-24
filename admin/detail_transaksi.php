<?php
session_start();
require "../config.php";
if (!isset($_SESSION["login_admin"])) {
  header("location:../login.php");
}
$id = $_GET["id"];
$sql_produk = sql("SELECT * FROM detail_transaksi INNER JOIN produk ON detail_transaksi.id_produk=produk.id_produk WHERE id_transaksi='$id'");
$no = 1;

$cek = sql("SELECT `status` FROM transaksi WHERE id_transaksi='$id'");
$hasil = $cek->fetch_assoc();

$potong = $sql_produk->fetch_assoc();

$total_potong = $potong['qty_produk'] - $potong['qty_transaksi'];
$id_produk = $potong['id_produk'];

if (isset($_POST["submit"])) {
  $update_transaksi = sql("UPDATE transaksi SET `status`='Sedang Diproses' , no_resi='$_POST[no_resi]' WHERE id_transaksi='$id'");
  $update_produk = sql("UPDATE produk SET qty_produk=$total_potong WHERE id_produk='$id_produk'");
  echo "
        <script>
        alert('Data berhasil Ditambahkan');
        document.location.href = 'daftar_transaksi.php';
        </script>
        ";
}
include "header.php";
?>


<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">DETAIL BARANG</h1>
  </div>

  <!-- Content Row -->
  <!-- Data Table -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width=5%>No</th>
              <th>Nama Produk</th>
              <th>QTY</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sql_produk as $produk) : ?>
              <tr>
                <th class="text-center"><?= $no; ?></th>
                <th><?= $produk['nama_produk']; ?></th>
                <th><?= $produk['qty_transaksi']; ?></th>
              </tr>
            <?php
              $no++;
            endforeach ?>
          </tbody>
        </table>
      </div>
      <a href="daftar_transaksi.php" class="btn btn-outline-secondary">Halaman Utama</a>
      <!-- Button trigger modal -->
      <?php if ($hasil['status'] == 'Belum Diproses') { ?>
        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
          Proses Pesanan
        </button>
        <a href="cancel_order.php?id=<?= $id; ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">Cancel Pesanan</a>
        <a href="resi.php?id=<?= $id; ?>" class="btn btn-outline-info">Cetak Resi</a>
      <?php } ?>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Masukan Nomor Resi Pengiriman</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="post">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" placeholder="Nomor Resi" name="no_resi" required>
                  <small>Pastikan anda memasukan nomor Resi dengan benar</small>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
              </form>
            </div>
          </div>
        </div>
      </div>
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
      <span>Copyright &copy; Nadia Ryan Jewelry 2023</span>
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

<!-- Datatables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.js"></script>

<script>
  $(document).ready(function() {
    $('#myTable').DataTable({
      dom: 'Bfrtip',
      buttons: [{
          extend: 'excelHtml5',
          title: 'Data Pesanan Barang',
          exportOptions: {
            columns: [0, 1, 2]
          }
        },
        {
          extend: 'pdfHtml5',
          title: 'Data Pesanan Barang',
          exportOptions: {
            columns: [0, 1, 2]
          }
        }
      ]
    });
  });
</script>


</body>

</html>