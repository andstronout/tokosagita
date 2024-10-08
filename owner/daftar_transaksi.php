<?php
session_start();
require "../config.php";
if (!isset($_SESSION["login_owner"])) {
  header("location:../login.php");
}

$no = 1;
$total_bayar = 0; // Inisialisasi total bayar
include "header.php";

// Cek jika reset ditekan
if (isset($_GET['reset'])) {
  // Hapus session tanggal
  unset($_SESSION["awal"]);
  unset($_SESSION["akhir"]);
}

// Proses filter atau tampilkan semua data
if (isset($_POST['simpan'])) {
  $_SESSION["awal"] = $_POST["t_awal"];
  $_SESSION["akhir"] = $_POST["t_akhir"];
  $sql_produk = sql("SELECT * FROM transaksi 
            INNER JOIN user ON transaksi.id_user=user.id_user 
            WHERE transaksi.tanggal_transaksi BETWEEN '$_SESSION[awal]' AND '$_SESSION[akhir]'
            ORDER BY transaksi.tanggal_transaksi");
} else {
  // Tampilkan semua data jika session tanggal kosong
  $sql_produk = sql("SELECT * FROM transaksi 
            INNER JOIN user ON transaksi.id_user=user.id_user 
            ORDER BY `transaksi`.`id_transaksi` DESC");
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Transaksi</h1>
  </div>

  <!-- Content Row -->
  <!-- Data Table -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <form class="row g-3" action="" method="post">
        <div class="col-auto">
          <label for="">Dari Tanggal</label>
          <input type="date" class="form-control" name="t_awal" required>
        </div>
        <div class="col-auto">
          <label for="">Ke Tanggal</label>
          <input type="date" class="form-control" name="t_akhir" required>
        </div>
        <div class="col-auto mt-4">
          <button type="submit" class="btn btn-secondary btn-sm" name="simpan">Simpan</button>
          <a href="daftar_transaksi.php?reset=true" class="btn btn-outline-secondary btn-sm">Reset</a>
        </div>
      </form>
      <div class="mt-3">
        <a class="btn btn-sm btn-info" href="export_pdf.php">Print PDF</a>
        <a class="btn btn-sm btn-info" href="export_excel.php">Print Excel</a>
      </div>

      <br>
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width=5%>No</th>
              <th>Nomor Transaksi</th>
              <th>Nama Pelanggan</th>
              <th>Tanggal Transaksi</th>
              <th>Resi Pengiriman</th>
              <th>Status</th>
              <th>Total Bayar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sql_produk as $transaksi) : ?>
              <tr>
                <th class="text-center"><?= $no; ?></th>
                <th><?= $transaksi['id_pesanan']; ?></th>
                <th><?= $transaksi['nama_user']; ?></th>
                <th><?= $transaksi['tanggal_transaksi']; ?></th>
                <th>
                  <?php if ($transaksi['no_resi'] == NULL) {
                    echo "Belum ada resi";
                  } else {
                    echo $transaksi['no_resi'];
                  }
                  ?>
                </th>
                <th><?= $transaksi['status']; ?></th>
                <th>Rp. <?= number_format($transaksi['total_transaksi']); ?></th>
              </tr>
            <?php
              $no++;
              $total_bayar += $transaksi['total_transaksi']; // Hitung total bayar
            endforeach ?>
            <tr>
              <th colspan="6" class="text-center"><strong>TOTAL BAYAR</strong></th>
              <th><strong>Rp. <?= number_format($total_bayar); ?></strong></th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; SagitaCollection 2024</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

<!-- End of Content Wrapper -->
</div>

<!-- End of Page Wrapper -->
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
          title: 'Data Transaksi',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6]
          }
        },
        {
          extend: 'pdfHtml5',
          title: 'Data Transaksi',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6]
          }
        }
      ]
    });
  });
</script>

</body>

</html>