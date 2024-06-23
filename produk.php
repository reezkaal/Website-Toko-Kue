<?php
session_start();
include 'koneksi.php';
?>

<?php
include 'header.php';
if (!empty($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
} else {
    $keyword = "";
}
?>
<div class="container-fluid page-header py-6 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center pt-5 pb-3">
        <h1 class="display-4 text-white animated slideInDown mb-3">Menu</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Menu</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-6">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <p class="text-primary text-uppercase mb-2">Menu</p>
            <h1 class="display-6 mb-4">Menu</h1>
        </div>
        <div class="row mb-5">
            <div class="col-md-12">
                <form method="post">
                    <div class="row">
                        <div class="col-md-9  my-auto">
                            <div class="form-group">
                                <input type="text" name="keyword" value="<?= $keyword ?>" placeholder="Masukkan kata pencarian" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="cari" value="cari" class="btn btn-primary w-100" style="padding:14px">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row g-4">
            <?php
            $ambil = $koneksi->query("SELECT * FROM produk LEFT JOIN kategori ON produk.idkategori=kategori.idkategori WHERE namaproduk LIKE '%$keyword%' OR namaproduk LIKE '%$keyword%' OR hargaproduk LIKE '%$keyword%' OR namakategori LIKE '%$keyword%' ORDER BY idproduk DESC");

            while ($produk = $ambil->fetch_assoc()) {
                $idproduk = $produk['idproduk'];

                $ambilulasan = $koneksi->query("SELECT sum(bintang) as totalbintang FROM ulasan WHERE ulasan.idproduk = '$idproduk'");
                $dataulasan = $ambilulasan->fetch_assoc();
                $ambilulasan = $koneksi->query("SELECT * FROM ulasan WHERE ulasan.idproduk = '$idproduk'");
                $hitungulasan = $ambilulasan->num_rows;

                $jumlahulasan = ($hitungulasan == 0) ? 1 : $hitungulasan;
                $rataulasan = $dataulasan['totalbintang'] / $jumlahulasan;

                $kritik = "";
                for ($i = 1; $i <= 5; $i++) {
                    $starClass = ($rataulasan >= $i) ? 'checked' : '';
                    $kritik .= '<span class="fa fa-star ' . $starClass . '" style="color:#ffc700;font-size:15pt;margin-right:2px;"></span>';
                }

                echo '
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="team-item text-center rounded overflow-hidden">
                <img style="height: 400px; object-fit: cover;" class="img-fluid" src="foto/' . $produk['fotoproduk'] . '" alt="">
                <div class="team-text">
                    <div class="team-title">
                        <h5>' . $produk["namaproduk"] . '</h5>
                        <span>' . $produk['namakategori'] . '</span>
                        <span>Rp ' . number_format($produk['hargaproduk']) . '</span>
                        <div style="display:flex; align-items: center;">' . $kritik . '</div>
                    </div>
                    <div class="team-social">
                        <a href="detail.php?id=' . $produk['idproduk'] . '" class="btn btn-primary rounded-pill py-3 px-5 w-100">Pesan</a>
                    </div>
                </div>
            </div>
        </div>';
            }
            ?>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>