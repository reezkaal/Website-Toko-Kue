<?php
include 'koneksi.php';
$datakategori = array();
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
  $datakategori[] = $tiap;
}
function tanggal($tgl)
{
  $tanggal = substr($tgl, 8, 2);
  $bulan = getBulan(substr($tgl, 5, 2));
  $tahun = substr($tgl, 0, 4);
  return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
function getBulan($bln)
{
  switch ($bln) {
    case 1:
      return "Januari";
      break;
    case 2:
      return "Februari";
      break;
    case 3:
      return "Maret";
      break;
    case 4:
      return "April";
      break;
    case 5:
      return "Mei";
      break;
    case 6:
      return "Juni";
      break;
    case 7:
      return "Juli";
      break;
    case 8:
      return "Agustus";
      break;
    case 9:
      return "September";
      break;
    case 10:
      return "Oktober";
      break;
    case 11:
      return "November";
      break;
    case 12:
      return "Desember";
      break;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Kedai Kanzoe</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <link href="home/img/logo.jpg" rel="icon">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="home/lib/animate/animate.min.css" rel="stylesheet">
  <link href="home/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="home/css/bootstrap.min.css" rel="stylesheet">
  <link href="home/css/style.css" rel="stylesheet">
  <style>
    .whats-app {
      position: fixed;
      width: 50px;
      height: 50px;
      bottom: 40px;
      background-color: #25d366;
      color: #FFF;
      border-radius: 50px;
      text-align: center;
      font-size: 30px;
      box-shadow: 3px 4px 3px #999;
      right: 15px;
      /* Mengubah properti left menjadi right */
      z-index: 100;
    }

    .my-float {
      margin-top: 10px;
    }

    .random-icon {
      position: fixed;
      width: 50px;
      height: 50px;
      bottom: 100px;
      /* Atur posisi sesuai kebutuhan */
      background-color: #FFC107;
      /* Ubah warna sesuai kebutuhan */
      color: #FFF;
      border-radius: 50px;
      text-align: center;
      font-size: 30px;
      box-shadow: 3px 4px 3px #999;
      right: 15px;
      /* Mengatur posisi ke kanan */
      z-index: 100;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
    <a href="index.php" class="navbar-brand ms-4 ms-lg-0">
      <img src="home/img/logo.jpg" width="80px" style="border-radius: 10px;">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">
        <a href="index.php" class="nav-item nav-link active">Home</a>
        <a href="produk.php" class="nav-item nav-link">Produk</a>
        <div class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Kategori</a>
          <div class="dropdown-menu m-0">
            <?php foreach ($datakategori as $key => $value) : ?>
              <a href="kategori.php?id=<?php echo $value["idkategori"] ?>" class="dropdown-item"><?php echo $value["namakategori"] ?></a>
            <?php endforeach ?>
          </div>
        </div>
        <?php
        if (isset($_SESSION["pengguna"])) { ?>
          <?php
          $id = $_SESSION["pengguna"]['id'];
          $ambil = $koneksi->query("SELECT *FROM pengguna WHERE id='$id'");
          $pecah = $ambil->fetch_assoc(); ?>
          <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Akun</a>
            <div class="dropdown-menu m-0">
              <a href="akun.php" class="dropdown-item">Profil Akun</a>
              <a href="riwayat.php" class="dropdown-item">Riwayat Belanja</a>
              <a href="keranjang.php" class="dropdown-item">Keranjang</a>
              <a href="logout.php" class="dropdown-item">Keluar</a>
            </div>
          </div>
          <?php
          if (isset($_SESSION['keranjang'])) {
            $keranjang = $_SESSION['keranjang'];

            $totalProduk = count($keranjang);
          } else {
            $totalProduk = 0;
          }
          ?>

          <li class="nav-item cta cta-colored">
            <a href="keranjang.php" class="nav-link">
              <i class="bi bi-cart"></i>
              [<span class="cart-item-total"><?php echo $totalProduk; ?></span>]
            </a>
          </li>
        <?php } else { ?>
          <a href="daftar.php" class="nav-item nav-link">Daftar</a>
          <a href="login.php" class="nav-item nav-link">Login</a>
        <?php } ?>
      </div>
    </div>
  </nav>