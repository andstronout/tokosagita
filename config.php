<?php
function koneksi()
{
  $conn = new mysqli('localhost', 'root', '', 'tokosagita') or die(mysqli_error($conn));
  return $conn;
}

function sql($sql)
{
  $conn = koneksi();
  $query = $conn->query($sql) or die(mysqli_error($conn));

  return $query;
}

function login()
{
  $conn = koneksi();
  if (isset($_POST['submit'])) {
    // Ambil dari form
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    // var_dump($email, $password);

    // ambil dari DB
    $sql = $conn->query("SELECT * FROM user WHERE email='$email' AND `password`='$password'");
    $user = $sql->fetch_assoc();
    // var_dump($user);

    if (!empty($user)) {
      if ($user['level'] == 1) {
        $_SESSION['login_pelanggan'] = true;
        $_SESSION['id_pelanggan'] = $user['id_user'];
        header("location:index.php");
      } elseif ($user['level'] == 2) {
        $_SESSION['login_admin'] = true;
        $_SESSION['id_admin'] = $user['id_user'];
        header("location:admin/index.php");
      } else {
        $_SESSION['login_owner'] = true;
        $_SESSION['id_owner'] = $user['id_user'];
        header("location:owner/index.php");
      }
    } else {
      echo "
        <script>
        alert('Email atau Password salah');
        document.location.href = 'login.php';
        </script>
        ";
    }
  }
}

function register()
{
  $conn = koneksi();
  if (isset($_POST["submit"])) {
    $alamat = $_POST["alamat"];
    $password = md5($_POST["password"]);
    $nomor_hp = $_POST["nomor_hp"];
    $sql_user = sql("SELECT email FROM user WHERE email='$_POST[email]'");
    $user = $sql_user->fetch_assoc();
    if (!empty($user)) {
      echo "
        <script>
        alert('Email sudah digunakan');
        document.location.href = 'register.php';
        </script>
        ";
    } else {
      // var_dump($nomor_hp);
      $tambah = sql("INSERT INTO user (nama_user, email, `password`, nomor_hp, alamat, `level`) VALUES ('$_POST[nama_user]','$_POST[email]','$password','$nomor_hp','$alamat','1')");
      echo "
        <script>
        alert('Data berhasil Ditambahkan');
        document.location.href = 'login.php';
        </script>
        ";
      return $tambah;
    }
  }
}

function ubahProfil()
{
  $conn = koneksi();
  $id = $_SESSION['id_pelanggan'];
  $nama_pelanggan = $_POST['nama_user'];
  $nomor_hp = $_POST['nomor_hp'];
  $alamat = $_POST['alamat'];

  if (isset($_POST['submit'])) {
    $update = ("UPDATE user SET nama_user='$nama_pelanggan', nomor_hp='$nomor_hp', alamat='$alamat' WHERE id_user='$id'");
    if ($conn->query($update) == true) {
      echo "
      <script>
      alert('Data Profile berhasil diubah!');
      window.location.href='index.php';
      </script>
      ";
    } else {
      echo '
      <scrpit>
      alert("Data Profile gagal diubah!");
      </scrpit>
      ';
    }
  }
}

function ubahPassword()
{
  if (isset($_POST['submit'])) {
    $conn = koneksi();
    $id = $_SESSION['id_pelanggan'];
    $sql = $conn->query("SELECT * FROM user WHERE id_user='$id'");
    $query = $sql->fetch_assoc();

    $passwordlama = md5($_POST['password_lama']);
    $passwordbaru = md5($_POST['password_baru']);
    $ulang_password = md5($_POST['ulang_password']);

    $update = ("UPDATE user SET `password`='$passwordbaru' WHERE id_user='$id'");
    // var_dump($passwordbaru, $passwordlama, $ulang_password);
    // Check password lama bener ga
    if ($passwordlama !== $query['password']) {
      echo '
      <script>
      alert("Masukan Password lama dengan benar!");
      </script>
      ';
      // Check password baru 2 form sama ga 
    } elseif ($passwordlama == $passwordbaru) {
      echo '
      <script>
      alert("Password tidak boleh sama!");
      </script>
      ';
    } elseif ($passwordbaru !== $ulang_password) {
      echo '
      <script>
      alert("Masukan password baru dengan benar!");
      </script>
      ';
    } elseif ($conn->query($update) == true) {
      echo "
      <script>
      alert('Password berhasil diubah!');
      window.location.href='index.php';
      </script>
      ";
    } else {
      echo '
      <script>
      alert("Password gagal diubah!");
      </script>
      ';
    }
  }
}

function cart()
{
  $conn = koneksi();

  if (isset($_POST["submit"])) {
    // Cek apakah pengguna sudah login
    if (!isset($_SESSION['login_pelanggan'])) {
      echo "
                <script>
                alert('Anda belum login. Silahkan login terlebih dahulu!');
                document.location.href = 'login.php';
                </script>
                ";
      return;
    }

    // Ambil produk yang dipilih berdasarkan id_produk
    $id_produk = $_POST["id_produk"];
    $qty_cart = $_POST["qty_cart"];

    $sql_produk = $conn->query("SELECT * FROM produk WHERE id_produk = '$id_produk'");
    $produk = $sql_produk->fetch_assoc();

    // Periksa apakah produk tersedia
    if (!$produk) {
      echo "
                <script>
                alert('Produk tidak ditemukan');
                document.location.href = 'index.php';
                </script>
                ";
      return;
    }

    // Ambil data keranjang berdasarkan id_user dan id_produk
    $sql_cart = $conn->query("SELECT * FROM cart WHERE id_user='$_SESSION[id_pelanggan]' AND id_produk='$id_produk'");
    $cart = $sql_cart->fetch_assoc();

    // Hitung total kuantitas yang akan ada di keranjang jika produk sudah ada di keranjang
    $total_qty_cart = $cart ? $cart['qty_cart'] + $qty_cart : $qty_cart;

    // Periksa apakah stok produk mencukupi untuk penambahan ini
    if ($total_qty_cart > $produk['qty_produk']) {
      echo "
                <script>
                alert('Maaf, jumlah total produk di keranjang anda telah melebihi stok yang tersedia.');
                document.location.href = 'index.php';
                </script>
                ";
      return;
    }

    // Jika produk sudah ada di keranjang, perbarui jumlahnya
    if ($cart) {
      $update_cart = $conn->query("UPDATE cart SET qty_cart='$total_qty_cart' WHERE id_produk='$id_produk'");
      echo "
                <script>
                alert('Produk Ditambahkan, Check keranjang belanja untuk proses checkout');
                document.location.href = 'index.php';
                </script>
                ";
      return $update_cart;
    } else {
      // Tambahkan produk baru ke keranjang
      $tambah = $conn->query("INSERT INTO cart (id_user, id_produk, qty_cart) VALUES ('$_SESSION[id_pelanggan]', '$id_produk', '$qty_cart')");
      echo "
                <script>
                alert('Produk Ditambahkan, Check keranjang belanja untuk proses checkout');
                document.location.href = 'index.php';
                </script>
                ";
      return $tambah;
    }
  }
}
